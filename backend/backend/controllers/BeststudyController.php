<?php

namespace backend\controllers;

use Yii;
use app\models\Beststudy;
use app\models\BeststudySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class BeststudyController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

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
        $searchModel = new BeststudySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = new Query();
        $data = $query->select('*')->from('beststudy')
                ->where(['best_study_id' => $id])
                ->all();
        
        return $this->render('view', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new Beststudy();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->best_study_image_cover = Yii::$app->Upload->Importimage($model, 'beststudy', 'uploads/beststudy/', 'best_study_image_cover');
            
            $model->create_by = $session['user_login'];
            $model->create_date = date("Y-m-d H:i:s");
            
            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->best_study_id]);
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
        
        $image_old = $model->best_study_image_cover;

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->best_study_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'beststudy', 'uploads/beststudy/', 'best_study_image_cover');          
            
            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->best_study_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/beststudy/'.$model->best_study_image_cover));
        }
        
        if($model->delete()){
            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');
            
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Beststudy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
