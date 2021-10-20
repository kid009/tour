<?php

namespace backend\controllers;

use Yii;
use app\models\TourismMainRoute;
use app\models\TourismMainRouteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class TourismMainRouteController extends Controller
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
        $searchModel = new TourismMainRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $tourSubRoute = Yii::$app->db->createCommand(
            "
                    select *
                    from tourism_sub_route
                    where tourism_main_route_id = $id
                    order by tourism_sub_route_order asc
                "
        )->queryAll();

        return $this->render('view', [
            'model' => $model,
            'tourSubRoute' => $tourSubRoute,
        ]);
    }

    public function actionCreate()
    {
        $model = new TourismMainRoute();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->tourism_main_route_image = Yii::$app->Upload->Importimage($model, 'tourism', 'uploads/tourism/', 'tourism_main_route_image');

            $model->tourism_main_route_contact_image = Yii::$app->Upload->Importimage($model, 'tourism', 'uploads/tourism/', 'tourism_main_route_contact_image');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->tourism_main_route_id]);
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

        $image_old = $model->tourism_main_route_image;
        $image_contact_old = $model->tourism_main_route_contact_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->tourism_main_route_image = Yii::$app->Upload->Updateimage($image_old, $model, 'tourism', 'uploads/tourism/', 'tourism_main_route_image');

            $model->tourism_main_route_contact_image = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'tourism', 'uploads/tourism/', 'tourism_main_route_contact_image');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->tourism_main_route_id]);
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

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/tourism/') . $model->tourism_main_route_image);
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
        if (($model = TourismMainRoute::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
