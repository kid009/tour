<?php

namespace backend\controllers;

use Yii;
use app\models\Culture;
use app\models\CultureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//get address
use yii\helpers\Json;
use app\models\Amphur;
use app\models\Tambon;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

class CultureController extends Controller
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
        $searchModel = new CultureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('culture')
            ->innerjoin('culture_group', 'culture_group.culture_group_id = culture.culture_group_id')
            ->innerJoin('community', 'community.community_id = culture.community_id')
            ->where(['culture.culture_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new Culture();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->culture_image_cover = Yii::$app->Upload->Importimage($model, 'culture', 'uploads/community/' . $model->community_id . '/culture/', 'culture_image_cover');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->culture_id]);
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

        $image_old = $model->culture_image_cover;

        $amphur = ArrayHelper::map($this->getAmphur($model->province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($model->amphur_id), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //save image
            $model->culture_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'culture', 'uploads/community/' . $model->community_id . '/culture/', 'culture_image_cover');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->culture_id]);
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

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/culture/' . $model->culture_image_cover));
        }

        if ($model->delete()) {

            $user = $session['user_login'];
            $date = Yii::$app->formatter->asDatetime(time());
            $request = Yii::$app->request->queryString;
            
            Yii::$app->db->createCommand("
            INSERT INTO public.bb_user_log(log_user, log_url, log_date)
            VALUES ('$user', '$request', '$date');
            ")->execute();
            
            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');

            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Culture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
    
    public function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }
    
}