<?php

namespace backend\controllers;

use Yii;
use app\models\People;
use app\models\PeopleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//get address
use yii\helpers\Json;
use app\models\Amphur;
use app\models\Tambon;

class PeopleController extends Controller
{
    public function init()
    {
        $session = new Session();
        $session->open();

        if(empty($session['user_id'])){
            return $this->redirect('index.php?r=account/login');
        }

        parent::init();
    }

    public function actionIndex()
    {
        $searchModel = new PeopleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('people')
                ->leftjoin('community', 'community.community_id = people.community_id')
                ->leftjoin('people_group', 'people_group.people_group_id = people.people_group_id')
                ->leftjoin('tb_province', 'tb_province.province_id = people.province_id')
                ->leftjoin('tb_amphur', 'tb_amphur.amphur_id = people.amphur_id')
                ->leftjoin('tb_tambon', 'tb_tambon.tambon_id = people.tambon_id')
                ->where(['people_id' => $id])->all();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new People();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //upload image
            $model->people_image = Yii::$app->Upload->Importimage($model, 'people', 'uploads/community/'.$model->community_id.'/people/','people_image');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', '???????????????????????????????????????????????????????????????.');
                
                return $this->redirect(['index']);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'amphur' => [],
            'tambon' => [],
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();

        $province_id = $model->province_id;
        $amphur_id = $model->amphur_id;
                
        $amphur = ArrayHelper::map($this->getAmphur($province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($amphur_id), 'id', 'name');
        
        $image_old = $model->people_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //upload image
            $model->people_image = Yii::$app->Upload->Updateimage($image_old, $model, 'people', 'uploads/community/'.$model->community_id.'/people/','people_image');          
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', '????????????????????????????????????????????????????????????.');
                
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'amphur' => $amphur,
            'tambon' => $tambon,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/people/'.$model->people_image));
        }
        
        if($model->delete()){

            $user = $session['user_login'];
            $date = Yii::$app->formatter->asDatetime(time());
            $request = Yii::$app->request->queryString;
            
            Yii::$app->db->createCommand("
            INSERT INTO public.bb_user_log(log_user, log_url, log_date)
            VALUES ('$user', '$request', '$date');
            ")->execute();
            
            $session->setFlash('message', '???????????????????????????????????????????????????.');
            
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = People::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    } 

    public function actionGetAmphur() 
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function actionGetTambon()
    {
        if(isset($_POST['depdrop_parents'])){
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            
            if($province_id != null){
                $data = $this->getTambon($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    
    public function getAmphur($id)
    {
        $datas = Amphur::find()->where(['province_id'=>$id])->all();
        return $this->MapData($datas,'amphur_id','amphur_name');
    }
    
    public function getTambon($id)
    {
        $datas = Tambon::find()->where(['amphur_id' => $id])->all();
        return $this->MapData($datas, 'tambon_id', 'tambon_name');
    }
    
}
