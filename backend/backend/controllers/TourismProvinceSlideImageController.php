<?php

namespace backend\controllers;

use Yii;
use app\models\TourismProvinceSlideImage;
use app\models\TourismProvinceSlideImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class TourismProvinceSlideImageController extends Controller
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
        $searchModel = new TourismProvinceSlideImageSearch();
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

    public function actionCreate()
    {
        $model = new TourismProvinceSlideImage();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->tourism_province_silde_image_name = Yii::$app->Upload->ImportSlideImage($model, 'slide_image', 'uploads/frontend/slide_image/', 'tourism_province_silde_image_name');

            $model->type_slide_image = 'Header';
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['index', 'id' => $model->tourism_province_slide_image_id]);
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
        
        $image_old = $model->tourism_province_silde_image_name;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //upload image    
            $model->tourism_province_silde_image_name = Yii::$app->Upload->UpdateSlideImage($image_old, $model, 'slide_image', 'uploads/frontend/slide_image/','tourism_province_silde_image_name');         

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย');
                
                return $this->redirect(['index', 'id' => $model->tourism_province_slide_image_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/frontend/slide_image/').$model->tourism_province_silde_image_name);
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
        if (($model = TourismProvinceSlideImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
