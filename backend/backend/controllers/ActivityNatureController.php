<?php

namespace backend\controllers;

use Yii;
use app\models\ActivityNature;
use app\models\ActivityNatureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

class ActivityNatureController extends Controller
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
        $searchModel = new ActivityNatureSearch();
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

    public function actionCreate($activity_id)
    {
        $model = new ActivityNature();
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['activity/view', 'id' => $model->activity_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'activity_id' => $activity_id,
        ]);
    }

    public function actionUpdate($id, $activity_id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['activity/view', 'id' => $model->activity_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'activity_id' => $activity_id,
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
            
            return $this->redirect(['activity/view', 'id' => $model->activity_id]);
        }
    }

    protected function findModel($id)
    {
        if (($model = ActivityNature::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
