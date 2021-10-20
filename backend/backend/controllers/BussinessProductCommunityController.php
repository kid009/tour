<?php

namespace backend\controllers;

use Yii;
use app\models\BussinessProductCommunity;
use app\models\BussinessProductCommunitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\BussinessImage;

class BussinessProductCommunityController extends Controller
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
        $searchModel = new BussinessProductCommunitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $data = Yii::$app->db->createCommand("
            SELECT bussiness_product_community_id, bussiness_product_community_group_name, community_name, bussiness_product_community_name, bussiness_product_community_name_en, bussiness_product_community_detail, bussiness_product_community_detail_en, bussiness_product_community_story, bussiness_product_community_image_cover, bussiness_product_community_vdo, bussiness_product_community_link
            FROM bussiness_product_community
            inner join bussiness_product_community_group on bussiness_product_community.bussiness_product_community_group_id = bussiness_product_community_group.bussiness_product_community_group_id
            inner join community on bussiness_product_community.community_id = community.community_id
            where bussiness_product_community_id = $id
        ")->queryAll();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new BussinessProductCommunity();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->bussiness_product_community_image_cover = Yii::$app->Upload->Importimage($model, 'bussiness', 'uploads/bussiness/product_community/', 'bussiness_product_community_image_cover');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
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

        $image_old = $model->bussiness_product_community_image_cover;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->bussiness_product_community_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'bussiness', 'uploads/bussiness/product_community/', 'bussiness_product_community_image_cover');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
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
            @unlink(Yii::getAlias('@webroot/uploads/bussiness/product_community/' . $model->bussiness_product_community_image_cover));
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

    public function actionImageIndex($id)
    {
        $model = $this->findModel($id);

        $images = BussinessImage::find()->where(['ref_id' => $id, 'bussiness_type_id' => 3])->all();
        //var_dump($BussinessKnowhowImages);

        return $this->render('image/index', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    public function actionImageCreate($id)
    {
        $data = $this->findModel($id);
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
            $model->ref_id = $id;

            //save image
            $model->bussiness_image_file = Yii::$app->Upload->Importimage($model, 'bussiness', 'uploads/bussiness/product_community/', 'bussiness_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['image-index', 'id' => $id]);
            }
        }

        return $this->render('image/create', [
            'model' => $model,
            'data' => $data,
            'id' => $id,
        ]);
    }

    public function actionImageUpdate($id, $bussiness_image_id)
    {
        $data = $this->findModel($id);
        $model = BussinessImage::findOne($bussiness_image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->bussiness_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->ref_id = $id;

            $model->bussiness_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'bussiness', 'uploads/bussiness/product_community/', 'bussiness_image_file');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['image-index', 'id' => $id]);
            }
        }

        return $this->render('image/update', [
            'model' => $model,
            'data' => $data,
            'id' => $id,
        ]);
    }

    public function actionImageDelete($id, $bussiness_image_id)
    {
        $model = BussinessImage::findOne($bussiness_image_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/bussiness/product_community/') . $model->bussiness_image_file);
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

            return $this->redirect(['image-index', 'id' => $id]);
        }
    }

    protected function findModel($id)
    {
        if (($model = BussinessProductCommunity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
