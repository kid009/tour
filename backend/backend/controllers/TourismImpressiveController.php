<?php

namespace backend\controllers;

use app\models\TourismImpressive;
use app\models\TourismImpressiveSearch;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

//check unique
use yii\web\Session;
use yii\widgets\ActiveForm;

class TourismImpressiveController extends Controller
{
    public function init()
    {
        $session = new Session();
        $session->open();

        if (empty($session['user_id'])) {
            return $this->redirect('index.php?r=account/login');
        }

        parent::init();
    }

    public function actionIndex()
    {
        $searchModel = new TourismImpressiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('tourism_impressive')
            ->innerjoin('tourism_impressive_group', 'tourism_impressive_group.tourism_impressive_group_id = tourism_impressive.tourism_impressive_group_id')
            ->where(['tourism_impressive.tourism_impressive_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new TourismImpressive();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->tourism_impressive_image_cover = Yii::$app->Upload->Importimage($model, 'tourism_impressive', 'uploads/tourism/impressive/', 'tourism_impressive_image_cover');

            $model->create_by = $session['user_login'];
            $model->create_date = date("Y-m-d H:i:s");

            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->tourism_impressive_id]);
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

        $image_old = $model->tourism_impressive_image_cover;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //save image
            $model->tourism_impressive_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'tourism_impressive', 'uploads/tourism/impressive/', 'tourism_impressive_image_cover');

            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->tourism_impressive_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/tourism/impressive/' . $model->tourism_impressive_image_cover));
        }

        if ($model->delete()) {

            $user = $session['user_login'];
            $date = Yii::$app->formatter->asDatetime(time());
            $request = Yii::$app->request->queryString;

            Yii::$app->db->createCommand("
            INSERT INTO public.bb_user_log(
            log_user, log_url, log_date)
            VALUES ('$user', '$request', '$date');
            ")->execute();

            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');

            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = TourismImpressive::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
