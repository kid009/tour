<?php

namespace backend\controllers;

use Yii;
use app\models\TourismSubRoute;
use app\models\TourismSubRouteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class TourismSubRouteController extends Controller
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
        $searchModel = new TourismSubRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('tourism_sub_route')
                ->innerJoin('tourism_main_route', 'tourism_main_route.tourism_main_route_id = tourism_sub_route.tourism_main_route_id')
                ->where(['tourism_sub_route.tourism_sub_route_id' => $id])
                ->all();       
        
        //$queryTourismSubRouteActivity = new Query();
        /*$tourismSubRouteActivity = $queryTourismSubRouteActivity->select('*')
                                   ->from('tourism_sub_route_activity')
                                   ->innerJoin('activity', 'activity.activity_id =  tourism_sub_route_activity.activity_id')
                                   ->where(['tourism_sub_route_activity.tourism_sub_route_id' => $id])
                                   ->all();*/
        
        $tourismSubRouteActivity = Yii::$app->db->createCommand(
                                    "
                                        select tb_province.province_name ,community.community_name, activity.activity_name, tourism_sub_route_activity_id, tourism_sub_route_id, activity_duration,
                                        tourism_sub_route_activity_order
                                        from tourism_sub_route_activity
                                        inner join activity on (activity.activity_id = tourism_sub_route_activity.activity_id)
                                        inner join community on (community.community_id = activity.community_id)
                                        inner join tb_province on (tb_province.province_id = community.province_id)
                                        where tourism_sub_route_activity.tourism_sub_route_id = $id
                                        order by tourism_sub_route_activity_order asc
                                    "
                                    )->queryAll();
        
        if(isset($_POST['update'])){
            foreach ($_POST['positions'] as $position) {
                $index = $position[0];
                $newPosition = $position[1];

                Yii::$app->db->createCommand(
                "
                    UPDATE tourism_sub_route_activity
                    SET tourism_sub_route_activity_order = $newPosition
                    WHERE tourism_sub_route_activity_id = $index
                "
                )->execute();
            }
            exit('success');
        }
        
        return $this->render('view', [
            'data' => $data,
            'model' => $this->findModel($id),
            'tourismSubRouteActivity' => $tourismSubRouteActivity,
            'n' => 1,
        ]);
    }

    public function actionCreate($tourismMainRouteId)
    {
        $model = new TourismSubRoute();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->tourism_sub_route_image_cover = Yii::$app->Upload->Importimage($model, 'tourism', 'uploads/tourism/', 'tourism_sub_route_image_cover');

            $model->tourism_sub_route_contact_image = Yii::$app->Upload->Importimage($model, 'tourism', 'uploads/tourism/', 'tourism_sub_route_contact_image');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->tourism_sub_route_id]);
            }
        }
        
        
        if($tourismMainRouteId != ""){
            return $this->render('create', [
                'model' => $model,
                'tourismMainRouteId' => $tourismMainRouteId    
            ]);
        }
        elseif($tourismMainRouteId == ""){
            return $this->render('create', [
                'model' => $model,
                'tourismMainRouteId' => $tourismMainRouteId    
            ]);
        }
    }

    public function actionUpdate($id, $from, $tourismMainRouteId)
    {
        $model = $this->findModel($id);        
        
        $session = new Session();
        $session->open();
        
        $image_old = $model->tourism_sub_route_image_cover;
        $image_contact_old = $model->tourism_sub_route_contact_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->tourism_sub_route_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'tourism', 'uploads/tourism/', 'tourism_sub_route_image_cover');

            $model->tourism_sub_route_contact_image = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'tourism', 'uploads/tourism/', 'tourism_sub_route_contact_image');
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                if($from != ""){
                    return $this->redirect([$from, 'id' => $model->tourism_main_route_id]);
                }
                
                return $this->redirect(['index', 'id' => $model->tourism_sub_route_id]);
            }           
        }
        
        if($tourismMainRouteId != ""){
            return $this->render('update', [
                'model' => $model,
                'tourismMainRouteId' => $tourismMainRouteId    
            ]);
        }
        elseif($tourismMainRouteId == ""){
            return $this->render('update', [
                'model' => $model,
                'tourismMainRouteId' => $tourismMainRouteId    
            ]);
        }
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
            
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = TourismSubRoute::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
