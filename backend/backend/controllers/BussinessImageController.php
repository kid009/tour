<?php

namespace backend\controllers;

use app\models\BussinessImage;
use app\models\BussinessProduct;
use Yii;
use yii\web\Controller;
use yii\web\Response;
//check unique
use yii\web\Session;
use yii\widgets\ActiveForm;

class BussinessImageController extends Controller
{
    // ---------- product community ----------
    public function actionProductIndex($bussiness_product_id)
    {
        $data = BussinessProduct::findOne($bussiness_product_id);

        $images = BussinessImage::find()->where(['ref_id' => $bussiness_product_id, 'bussiness_type_id' => 2])->all();
        //var_dump($BussinessKnowhowImages);

        return $this->render('product/index', [
            'data' => $data,
            'bussiness_product_id' => $bussiness_product_id,
            'images' => $images,
        ]);
    }

    public function actionProductCreate($bussiness_product_id)
    {
        $data = BussinessProduct::findOne($bussiness_product_id);
        $model = new BussinessImage();

        $type_id = Yii::$app->db->createCommand("select bussiness_type_id from bussiness_type where bussiness_type_name = 'product community' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->bussiness_type_id = $type_id[0]['bussiness_type_id'];
            $model->ref_id = $bussiness_product_id;

            //save image
            $model->bussiness_image_file = Yii::$app->Upload->Importimage($model, 'bussiness', 'uploads/bussiness/product/', 'bussiness_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['product-index', 'bussiness_product_id' => $bussiness_product_id]);
            }
        }

        return $this->render('product/create', [
            'model' => $model,
            'data' => $data,
            'bussiness_product_id' => $bussiness_product_id,
        ]);
    }

    public function actionProductUpdate($bussiness_product_id, $bussiness_image_id)
    {
        $data = BussinessProduct::findOne($bussiness_product_id);
        $model = BussinessImage::findOne($bussiness_image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->bussiness_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->ref_id = $bussiness_product_id;

            $model->bussiness_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'bussiness', 'uploads/bussiness/product/', 'bussiness_image_file');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['product-index', 'bussiness_product_id' => $bussiness_product_id]);
            }
        }

        return $this->render('product/update', [
            'model' => $model,
            'data' => $data,
            'bussiness_product_id' => $bussiness_product_id,
        ]);
    }

    public function actionProductDelete($bussiness_product_id, $bussiness_image_id)
    {
        $model = BussinessImage::findOne($bussiness_image_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/bussiness/product/') . $model->bussiness_image_file);
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

            return $this->redirect(['product-index', 'bussiness_product_id' => $bussiness_product_id]);
        }
    }
    // ---------- product community ----------

}
