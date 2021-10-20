<?php

namespace backend\controllers;

use app\models\TourismImage;
use app\models\TourismStory;
use app\models\TourismStorySearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//check unique
use yii\web\Response;
use yii\web\Session;
use yii\widgets\ActiveForm;

class TourismStoryController extends Controller
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
        $searchModel = new TourismStorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $data = Yii::$app->db->createCommand("
        SELECT tourism_story_id, tourism_story_group_name, tourism_story_name, tourism_story_name_en, tourism_story_detail, tourism_story_detail_en, tourism_story_image_cover, tourism_story_vdo, tourism_story_link,tourism_story_hashtag, is_active
        FROM tourism_story
        INNER JOIN tourism_story_group ON tourism_story.tourism_story_group_id = tourism_story_group.tourism_story_group_id
        WHERE tourism_story_id = $id
        ")->queryAll();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new TourismStory();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->tourism_story_image_cover = Yii::$app->Upload->Importimage($model, 'story_', 'uploads/tourism/story/', 'tourism_story_image_cover');

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

        $image_old = $model->tourism_story_image_cover;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->tourism_story_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'story_', 'uploads/tourism/story/', 'tourism_story_image_cover');

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
            @unlink(Yii::getAlias('@webroot/uploads/tourism/story/' . $model->tourism_story_image_cover));
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

    public function actionImageIndex($id)
    {
        $model = $this->findModel($id);

        $images = TourismImage::find()->where(['ref_id' => $id, 'tourism_type_id' => 4])->all();

        return $this->render('image/index', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    public function actionImageCreate($id)
    {
        $data = $this->findModel($id);
        $model = new TourismImage();

        $type_id = Yii::$app->db->createCommand("select tourism_type_id from tourism_type where tourism_type_name = 'story' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->tourism_type_id = $type_id[0]['tourism_type_id'];
            $model->ref_id = $id;

            //save image
            $model->tourism_image_file = Yii::$app->Upload->Importimage($model, 'story_', 'uploads/tourism/story/', 'tourism_image_file');

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

    public function actionImageUpdate($id, $tourism_image_id)
    {
        $data = $this->findModel($id);
        $model = TourismImage::findOne($tourism_image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->tourism_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->ref_id = $id;

            $model->tourism_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'story_', 'uploads/tourism/story/', 'tourism_image_file');

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

    public function actionImageDelete($id, $tourism_image_id)
    {
        $model = TourismImage::findOne($tourism_image_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/tourism/story/') . $model->tourism_image_file);
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

            return $this->redirect(['image-index', 'id' => $id]);
        }
    }

    protected function findModel($id)
    {
        if (($model = TourismStory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
