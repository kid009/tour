<?php

namespace backend\controllers;

use Yii;
use app\models\Nature;
use app\models\NatureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Community;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class NatureController extends Controller
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
        $searchModel = new NatureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('nature')
                ->innerJoin('community', 'community.community_id = nature.community_id')
                ->innerJoin('nature_group', 'nature_group.nature_group_id = nature.nature_group_id')
                ->where(['nature.nature_id' => $id])
                ->all();       
        
        return $this->render('view', [
            'data' => $data,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Nature();
        
        $session = new Session();
        $session->open();
        
        $community = ArrayHelper::map(Community::find()->all(), 'community_id', 'community_name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->nature_image_cover = Yii::$app->Upload->Importimage($model, 'nature', 'uploads/community/'.$model->community_id.'/nature/', 'nature_image_cover');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->nature_id]);
            }            
        }

        return $this->render('create', [
            'model' => $model,
            'community' => $community,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();
        
        $image_old = $model->nature_image_cover;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //upload image    
            $model->nature_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'nature', 'uploads/community/'.$model->community_id.'/nature/','nature_image_cover');
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูล'.$model->nature_name.'เรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->nature_id]);
            }            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/nature/'.$model->nature_image_cover));
        }
        
        if($model->delete()){

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
        if (($model = Nature::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
