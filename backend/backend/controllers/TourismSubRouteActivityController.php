<?php

namespace backend\controllers;

use Yii;
use app\models\TourismSubRouteActivity;
use app\models\TourismSubRouteActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;

class TourismSubRouteActivityController extends Controller
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
        $searchModel = new TourismSubRouteActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($tourism_sub_route_id)
    {
        $model = new TourismSubRouteActivity();
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {          
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['tourism-sub-route/view', 'id' => $model->tourism_sub_route_id]);
            }
        }            

        return $this->render('create', [
            'model' => $model,
            'tourism_sub_route_id' => $tourism_sub_route_id,
            
        ]);
    }

    public function actionUpdate($id, $tourism_sub_route_id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            
            $subRoute = \app\models\TourismSubRoute::findOne($model->tourism_sub_route_id);            
            $model->tourism_main_route_id = $subRoute->tourism_main_route_id;
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['tourism-sub-route/view', 'id' => $model->tourism_sub_route_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tourism_sub_route_id' => $tourism_sub_route_id,
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
            
            return $this->redirect(['tourism-sub-route/view', 'id' => $model->tourism_sub_route_id]);
        }
    }

    protected function findModel($id)
    {
        if (($model = TourismSubRouteActivity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function searchActivity()
    {
        
    }
    
}
