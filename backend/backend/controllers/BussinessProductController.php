<?php

namespace backend\controllers;

use app\models\BussinessProduct;
use app\models\BussinessProductSearch;
use app\models\BussinessProductType;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

//check unique
use yii\web\Session;
use yii\widgets\ActiveForm;

class BussinessProductController extends Controller
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
        $searchModel = new BussinessProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('bussiness_product')
            ->innerjoin('bussiness_product_group', 'bussiness_product_type', 'bussiness_product_group.bussiness_product_group_id = bussiness_product.bussiness_product_group_id', 'bussiness_product_type.bussiness_product_type_id = bussiness_product.bussiness_product_type_id')
            ->where(['bussiness_product.bussiness_product_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new BussinessProduct();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->bussiness_product_image_cover = Yii::$app->Upload->Importimage($model, 'bussiness_product', 'uploads/bussiness/product/', 'bussiness_product_image_cover');

            $model->create_by = $session['user_login'];
            $model->create_date = date("Y-m-d H:i:s");

            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->bussiness_product_id]);
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

        $image_old = $model->bussiness_product_image_cover;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //save image
            $model->bussiness_product_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'bussiness_product', 'uploads/bussiness/product/', 'bussiness_product_image_cover');

            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->bussiness_product_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/bussiness/product' . $model->bussiness_product_image_cover));
        }

        if ($model->delete()) {
            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');

            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = BussinessProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
