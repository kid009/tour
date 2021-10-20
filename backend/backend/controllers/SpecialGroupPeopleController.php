<?php

namespace backend\controllers;

use Yii;
use app\models\SpecialGroupPeople;
use app\models\SpecialGroupPeopleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\helpers\Json;
use yii\db\ActiveQuery;

class SpecialGroupPeopleController extends Controller
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
        $searchModel = new SpecialGroupPeopleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate($special_group_id, $community_id)
    {
        $model = new SpecialGroupPeople();
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['special-group/view', 'id' => $special_group_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'special_group_id' => $special_group_id,
            'community_id' => $community_id,
        ]);
    }

    public function actionUpdate($id, $community_id, $special_group_id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['special-group/view', 'id' => $special_group_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'special_group_id' => $special_group_id,
            'community_id' => $community_id,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();

        if($model->delete()){

            $user = $session['user_login'];
            $date = Yii::$app->formatter->asDatetime(time());
            $request = Yii::$app->request->queryString;
            
            Yii::$app->db->createCommand("
            INSERT INTO public.bb_user_log(log_user, log_url, log_date)
            VALUES ('$user', '$request', '$date');
            ")->execute();
            
            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');
            
            return $this->redirect(['special-group/view', 'id' => $model->special_group_id]);
        }
    }

    protected function findModel($id)
    {
        if (($model = SpecialGroupPeople::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    //------------ special group -----------
    public function actionGetSpecial() 
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $community_id = $parents[0];
                $out = $this->getSepcialgroup($community_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
 
    protected function getSepcialgroup($id)
    {
        $datas = \app\models\SpecialGroup::find()->where(['community_id'=>$id])->all();
        return $this->MapData($datas,'special_group_id','special_group_name');
    }
    //------------ special group -----------
    
    //------------ people -----------
    public function actionGetPeople() 
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $community_id = $parents[0];
                $out = $this->getPeople($community_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    protected function getPeople($id)
    {
        $datas = \app\models\People::find()->where(['community_id'=>$id])->all();
        return $this->MapData($datas,'people_id','people_name');
    }
    //------------ people -----------
    
    protected function MapData($datas,$fieldId,$fieldName)
    {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
        }
        return $obj;
    }
    
}
