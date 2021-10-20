<?php

namespace backend\controllers;

use Yii;
use app\models\TourismProvince;
use app\models\TourismProvinceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class TourismProvinceController extends Controller
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
        $searchModel = new TourismProvinceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $data = Yii::$app->db->createCommand(
                '
                    select * from tourism_province
                    where tourism_province_id = '.$id.'
                '
                )->queryAll();
        
        return $this->render('view', [
            'data' => $data,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new TourismProvince();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //upload image
            /*$model->tourism_province_image_1 = Yii::$app->Upload->Importimage($model, 'frontend', 'uploads/frontend/','tourism_province_image_1');
            $model->tourism_province_image_2 = Yii::$app->Upload->Importimage($model, 'frontend', 'uploads/frontend/','tourism_province_image_2');
            $model->tourism_province_image_3 = Yii::$app->Upload->Importimage($model, 'frontend', 'uploads/frontend/','tourism_province_image_3');*/
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){               
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->tourism_province_id]);
            }           
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();
        
        /*$image_old_1 = $model->tourism_province_image_1;
        $image_old_2 = $model->tourism_province_image_2;
        $image_old_3 = $model->tourism_province_image_3;*/

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            /*$model->tourism_province_image_1 = Yii::$app->Upload->Updateimage($image_old_1, $model, 'frontend', 'uploads/frontend/','tourism_province_image_1'); 
            $model->tourism_province_image_2 = Yii::$app->Upload->Updateimage($image_old_2, $model, 'frontend', 'uploads/frontend/','tourism_province_image_2');
            $model->tourism_province_image_3 = Yii::$app->Upload->Updateimage($image_old_3, $model, 'frontend', 'uploads/frontend/','tourism_province_image_3');*/
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย');
                
                return $this->redirect(['index', 'id' => $model->tourism_province_id]);
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
        if (($model = TourismProvince::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
