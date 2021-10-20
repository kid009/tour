<?php

namespace backend\controllers;

use Yii;
use app\models\CommunityImage;
//use app\models\CommunityImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Community;
use yii\web\Session;

class CommunityImageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }
    //-------------------- community --------------------
    public function actionIndex($id)
    {
        $Community = Community::findOne($id);
        $CommunityImage = CommunityImage::find()->where(['community_id' => $id, 'community_image_type' => "community"])->all();

        return $this->render('index', [
            'community' => $Community,
            'commuintyImage' => $CommunityImage,
            'n' => 1,
        ]);
    }

    public function actionForm($id)
    {
        $community = Community::findOne($id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $id;
            $model->ref_id = $id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "community";
            }
            $model->community_image_name = $model->community_image_name;
            //echo '-------------------------'.$model->community_image_name;
            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'community_', 'uploads/community/' . $id . '/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['index', 'id' => $id]);
            }
        }


        return $this->render('_form', [
            'model' => $model,
            'community' => $community
        ]);
    }

    public function actionFormEdit($id, $image_id)
    {
        $community = Community::findOne($id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $id;
            $model->ref_id = $id;

            $model->community_image_name = $model->community_image_name;
            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'community_', 'uploads/community/' . $id . '/', 'community_image_file');
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['index', 'id' => $id]);
            }
        }

        return $this->render('_form', [
            'model' => $model,
            'community' => $community
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/') . $model->community_image_file);
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

            return $this->redirect(['index', 'id' => $model->community_id]);
        }
    }
    //-------------------- community --------------------

    //-------------------- place --------------------
    public function actionPlaceIndex($com_id, $place_id)
    {
        $Community = Community::findOne($com_id);
        $CommunityImage = CommunityImage::find()
            ->where([
                'community_id' => $com_id,
                'ref_id' => $place_id,
            ])
            ->all();

        return $this->render('place/place_index', [
            'community' => $Community,
            'commuintyImage' => $CommunityImage,
            'place_id' => $place_id,
            'n' => 1,
        ]);
    }

    public function actionFormPlace($com_id, $place_id)
    {
        $community = Community::findOne($com_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $com_id;
            $model->ref_id = $place_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "place";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'place', 'uploads/community/' . $com_id . '/place/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['place-index', 'com_id' => $com_id, 'place_id' => $place_id]);
            }
        }


        return $this->render('place/form_place', [
            'model' => $model,
            'community' => $community,
            'place_id' => $place_id,
        ]);
    }

    public function actionFormEditPlace($com_id, $place_id, $image_id)
    {
        $community = Community::findOne($com_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $com_id;
            $model->ref_id = $place_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "place";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'place', 'uploads/community/' . $com_id . '/place/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['place-index', 'com_id' => $com_id, 'place_id' => $place_id]);
            }
        }

        return $this->render('place/form_place', [
            'model' => $model,
            'community' => $community,
            'place_id' => $place_id,
        ]);
    }

    public function actionPlaceDelete($com_id, $place_id)
    {
        $model = $this->findModel($com_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/place/') . $model->community_image_file);
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

            return $this->redirect(['place-index', 'com_id' => $model->community_id, 'place_id' => $place_id]);
        }
    }
    //-------------------- place --------------------

    //-------------------- culture --------------------
    public function actionCultureIndex($com_id, $culture_id)
    {
        $Community = Community::findOne($com_id);
        $CommunityImage = CommunityImage::find()
            ->where([
                'community_id' => $com_id,
                'ref_id' => $culture_id,
            ])
            ->all();

        return $this->render('culture/culture_index', [
            'community' => $Community,
            'commuintyImage' => $CommunityImage,
            'culture_id' => $culture_id,
            'n' => 1,
        ]);
    }

    public function actionFormCulture($com_id, $culture_id)
    {
        $community = Community::findOne($com_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {


            $model->community_id = $com_id;
            $model->ref_id = $culture_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "culture";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'culture', 'uploads/community/' . $com_id . '/culture/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['culture-index', 'com_id' => $com_id, 'culture_id' => $culture_id]);
            }
        }

        return $this->render('culture/form_culture', [
            'model' => $model,
            'community' => $community,
            'culture_id' => $culture_id,
        ]);
    }

    public function actionFormEditCulture($com_id, $culture_id, $image_id)
    {
        $community = Community::findOne($com_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {


            $model->community_id = $com_id;
            $model->ref_id = $culture_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "culture";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'culture', 'uploads/community/' . $com_id . '/culture/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['culture-index', 'com_id' => $com_id, 'culture_id' => $culture_id]);
            }
        }

        return $this->render('culture/form_culture', [
            'model' => $model,
            'community' => $community,
            'culture_id' => $culture_id,
        ]);
    }

    public function actionCultureDelete($com_id, $culture_id)
    {
        $model = $this->findModel($com_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/culture/') . $model->community_image_file);
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

            return $this->redirect(['culture-index', 'com_id' => $model->community_id, 'culture_id' => $culture_id]);
        }
    }
    //-------------------- culture --------------------

    //-------------------- nature --------------------
    public function actionNatureIndex($com_id, $nature_id)
    {
        $Community = Community::findOne($com_id);
        $CommunityImage = CommunityImage::find()
            ->where([
                'community_id' => $com_id,
                'ref_id' => $nature_id,
            ])
            ->all();

        return $this->render('nature/nature_index', [
            'community' => $Community,
            'commuintyImage' => $CommunityImage,
            'nature_id' => $nature_id,
            'n' => 1,
        ]);
    }

    public function actionFormNature($com_id, $nature_id)
    {
        $community = Community::findOne($com_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $com_id;
            $model->ref_id = $nature_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "nature";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'nature', 'uploads/community/' . $com_id . '/nature/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['nature-index', 'com_id' => $com_id, 'nature_id' => $nature_id]);
            }
        }


        return $this->render('nature/form_nature', [
            'model' => $model,
            'community' => $community,
            'nature_id' => $nature_id,
        ]);
    }

    public function actionFormEditNature($com_id, $nature_id, $image_id)
    {
        $community = Community::findOne($com_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $com_id;
            $model->ref_id = $nature_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "nature";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'nature', 'uploads/community/' . $com_id . '/nature/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['nature-index', 'com_id' => $com_id, 'nature_id' => $nature_id]);
            }
        }


        return $this->render('nature/form_nature', [
            'model' => $model,
            'community' => $community,
            'nature_id' => $nature_id,
        ]);
    }

    public function actionNatureDelete($com_id, $nature_id)
    {
        $model = $this->findModel($com_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/nature/') . $model->community_image_file);
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

            return $this->redirect(['nature-index', 'com_id' => $model->community_id, 'nature_id' => $nature_id]);
        }
    }
    //-------------------- nature --------------------

    //-------------------- activity --------------------
    public function actionActivityIndex($community_id, $activity_id)
    {
        $community = Community::findOne($community_id);
        $communityImage = CommunityImage::find()
            ->where([
                'community_id' => $community_id,
                'ref_id' => $activity_id,
            ])
            ->all();

        return $this->render('activity/activity_index', [
            'community' => $community,
            'communityImage' => $communityImage,
            'activity_id' => $activity_id,
            'n' => 1,
        ]);
    }

    public function actionFormActivity($community_id, $activity_id)
    {
        $community = Community::findOne($community_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $community_id;
            $model->ref_id = $activity_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "activity";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'activity', 'uploads/community/' . $community_id . '/activity/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['activity-index', 'community_id' => $community_id, 'activity_id' => $activity_id]);
            }
        }


        return $this->render('activity/form_activity', [
            'model' => $model,
            'community' => $community,
            'activity_id' => $activity_id,
        ]);
    }

    public function actionFormEditActivity($community_id, $activity_id, $image_id)
    {
        $community = Community::findOne($community_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $community_id;
            $model->ref_id = $activity_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "activity";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'activity', 'uploads/community/' . $community_id . '/activity/', 'community_image_file');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['activity-index', 'community_id' => $community_id, 'activity_id' => $activity_id]);
            }
        }

        return $this->render('activity/form_activity', [
            'model' => $model,
            'community' => $community,
            'activity_id' => $activity_id,
        ]);
    }

    public function actionActivityDelete($community_id, $activity_id)
    {
        $model = $this->findModel($community_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/activity/') . $model->community_image_file);
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

            return $this->redirect(['activity-index', 'community_id' => $model->community_id, 'activity_id' => $activity_id]);
        }
    }

    //-------------------- activity --------------------

    //-------------------- product --------------------
    public function actionProductIndex($community_id, $product_id)
    {
        $community = Community::findOne($community_id);
        $communityImage = CommunityImage::find()
            ->where([
                'community_id' => $community_id,
                'ref_id' => $product_id,
            ])
            ->all();

        return $this->render('product/product_index', [
            'community' => $community,
            'communityImage' => $communityImage,
            'product_id' => $product_id,
            'n' => 1,
        ]);
    }

    public function actionFormProduct($community_id, $product_id)
    {
        $community = Community::findOne($community_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $community_id;
            $model->ref_id = $product_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "product";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'product', 'uploads/community/' . $community_id . '/product/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['product-index', 'community_id' => $community_id, 'product_id' => $product_id]);
            }
        }

        return $this->render('product/form_product', [
            'model' => $model,
            'community' => $community,
            'product_id' => $product_id,
        ]);
    }

    public function actionFormEditProduct($community_id, $product_id, $image_id)
    {
        $community = Community::findOne($community_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $community_id;
            $model->ref_id = $product_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "product";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'product', 'uploads/community/' . $community_id . '/product/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['product-index', 'community_id' => $community_id, 'product_id' => $product_id]);
            }
        }

        return $this->render('product/form_product', [
            'model' => $model,
            'community' => $community,
            'product_id' => $product_id,
        ]);
    }

    public function actionProductDelete($community_id, $product_id)
    {
        $model = $this->findModel($community_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/product/') . $model->community_image_file);
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

            return $this->redirect(['product-index', 'community_id' => $model->community_id, 'product_id' => $product_id]);
        }
    }
    //-------------------- product --------------------

    //-------------------- knowhow --------------------
    public function actionKnowhowIndex($community_id, $knowhow_id)
    {
        $community = Community::findOne($community_id);
        $communityImage = CommunityImage::find()
            ->where([
                'community_id' => $community_id,
                'ref_id' => $knowhow_id,
            ])
            ->all();

        return $this->render('knowhow/knowhow_index', [
            'community' => $community,
            'communityImage' => $communityImage,
            'knowhow_id' => $knowhow_id,
            'n' => 1,
        ]);
    }

    public function actionFormKnowhow($community_id, $knowhow_id)
    {
        $community = Community::findOne($community_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $community_id;
            $model->ref_id = $knowhow_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "knowhow";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'knowhow_', 'uploads/community/' . $community_id . '/knowhow/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['knowhow-index', 'community_id' => $community_id, 'knowhow_id' => $knowhow_id]);
            }
        }


        return $this->render('knowhow/form_knowhow', [
            'model' => $model,
            'community' => $community,
            'knowhow_id' => $knowhow_id,
        ]);
    }

    public function actionFormEditKnowhow($community_id, $knowhow_id, $image_id)
    {
        $community = Community::findOne($community_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $community_id;
            $model->ref_id = $knowhow_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "knowhow";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'knowhow_', 'uploads/community/' . $community_id . '/knowhow/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['knowhow-index', 'community_id' => $community_id, 'knowhow_id' => $knowhow_id]);
            }
        }


        return $this->render('knowhow/form_knowhow', [
            'model' => $model,
            'community' => $community,
            'knowhow_id' => $knowhow_id,
        ]);
    }

    public function actionKnowhowDelete($community_id, $knowhow_id)
    {
        $model = $this->findModel($community_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/knowhow/') . $model->community_image_file);
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

            return $this->redirect(['knowhow-index', 'community_id' => $model->community_id, 'knowhow_id' => $knowhow_id]);
        }
    }
    //-------------------- knowhow --------------------

    //-------------------- tradition --------------------
    public function actionTraditionIndex($community_id, $tradition_id)
    {
        $community = Community::findOne($community_id);
        $communityImage = CommunityImage::find()
            ->where([
                'community_id' => $community_id,
                'ref_id' => $tradition_id,
            ])
            ->all();

        return $this->render('tradition/tradition_index', [
            'community' => $community,
            'communityImage' => $communityImage,
            'tradition_id' => $tradition_id,
            'n' => 1,
        ]);
    }

    public function actionFormTradition($community_id, $tradition_id)
    {
        $community = Community::findOne($community_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $community_id;
            $model->ref_id = $tradition_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "tradition";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'tradition', 'uploads/community/' . $community_id . '/tradition/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['tradition-index', 'community_id' => $community_id, 'tradition_id' => $tradition_id]);
            }
        }

        return $this->render('tradition/form_tradition', [
            'model' => $model,
            'community' => $community,
            'tradition_id' => $tradition_id,
        ]);
    }

    public function actionFormEditTradition($community_id, $tradition_id, $image_id)
    {
        $community = Community::findOne($community_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {

            $model->community_id = $community_id;
            $model->ref_id = $tradition_id;

            if ($model->community_image_type == "") {
                $model->community_image_type = "tradition";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'tradition', 'uploads/community/' . $community_id . '/tradition/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['tradition-index', 'community_id' => $community_id, 'tradition_id' => $tradition_id]);
            }
        }


        return $this->render('tradition/form_tradition', [
            'model' => $model,
            'community' => $community,
            'tradition_id' => $tradition_id,
        ]);
    }

    public function actionTraditionDelete($community_id, $tradition_id)
    {
        $model = $this->findModel($community_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/tradition/') . $model->community_image_file);
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

            return $this->redirect(['tradition-index', 'community_id' => $model->community_id, 'tradition_id' => $tradition_id]);
        }
    }
    //-------------------- tradition --------------------

    //-------------------- restaurant --------------------
    public function actionRestaurantIndex($community_id, $restaurant_id)
    {
        $community = Community::findOne($community_id);
        $communityImage = CommunityImage::find()
            ->where([
                'community_id' => $community_id,
                'ref_id' => $restaurant_id,
            ])
            ->all();

        return $this->render('restaurant/restaurant_index', [
            'community' => $community,
            'communityImage' => $communityImage,
            'restaurant_id' => $restaurant_id,
            'n' => 1,
        ]);
    }

    public function actionFormRestaurant($community_id, $restaurant_id)
    {
        $community = Community::findOne($community_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $community_id;
            $model->ref_id = $restaurant_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "restaurant";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'restaurant', 'uploads/community/' . $community_id . '/restaurant/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['restaurant-index', 'community_id' => $community_id, 'restaurant_id' => $restaurant_id]);
            }
        }


        return $this->render('restaurant/form_restaurant', [
            'model' => $model,
            'community' => $community,
            'restaurant_id' => $restaurant_id,
        ]);
    }

    public function actionFormEditRestaurant($community_id, $restaurant_id, $image_id)
    {
        $community = Community::findOne($community_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $community_id;
            $model->ref_id = $restaurant_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "restaurant";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'restaurant', 'uploads/community/' . $community_id . '/restaurant/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['restaurant-index', 'community_id' => $community_id, 'restaurant_id' => $restaurant_id]);
            }
        }


        return $this->render('restaurant/form_restaurant', [
            'model' => $model,
            'community' => $community,
            'restaurant_id' => $restaurant_id,
        ]);
    }

    public function actionRestaurantDelete($community_id, $restaurant_id)
    {
        $model = $this->findModel($community_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/restaurant/') . $model->community_image_file);
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

            return $this->redirect(['restaurant-index', 'community_id' => $model->community_id, 'restaurant_id' => $restaurant_id]);
        }
    }
    //-------------------- restaurant --------------------

    //-------------------- homestay --------------------
    public function actionHomestayIndex($community_id, $homestay_id)
    {
        $community = Community::findOne($community_id);
        $communityImage = CommunityImage::find()
            ->where([
                'community_id' => $community_id,
                'ref_id' => $homestay_id,
            ])
            ->all();

        return $this->render('homestay/homestay_index', [
            'community' => $community,
            'communityImage' => $communityImage,
            'homestay_id' => $homestay_id,
            'n' => 1,
        ]);
    }

    public function actionFormHomestay($community_id, $homestay_id)
    {
        $community = Community::findOne($community_id);
        $model = new CommunityImage();

        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $community_id;
            $model->ref_id = $homestay_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "homestay";
            }

            $model->community_image_file = Yii::$app->Upload->Importimage($model, 'homestay', 'uploads/community/' . $community_id . '/homestay/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['homestay-index', 'community_id' => $community_id, 'homestay_id' => $homestay_id]);
            }
        }


        return $this->render('homestay/form_homestay', [
            'model' => $model,
            'community' => $community,
            'homestay_id' => $homestay_id,
        ]);
    }

    public function actionFormEditHomestay($community_id, $homestay_id, $image_id)
    {
        $community = Community::findOne($community_id);
        $model = CommunityImage::findOne($image_id);

        $session = new Session();
        $session->open();

        $image_old = $model->community_image_file;

        if ($model->load(Yii::$app->request->post())) {
            $model->community_id = $community_id;
            $model->ref_id = $homestay_id;


            if ($model->community_image_type == "") {
                $model->community_image_type = "homestay";
            }

            $model->community_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'homestay', 'uploads/community/' . $community_id . '/homestay/', 'community_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());


            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['homestay-index', 'community_id' => $community_id, 'homestay_id' => $homestay_id]);
            }
        }


        return $this->render('homestay/form_homestay', [
            'model' => $model,
            'community' => $community,
            'homestay_id' => $homestay_id,
        ]);
    }

    public function actionHomestayDelete($community_id, $homestay_id)
    {
        $model = $this->findModel($community_id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/homestay/') . $model->community_image_file);
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

            return $this->redirect(['homestay-index', 'community_id' => $model->community_id, 'homestay_id' => $homestay_id]);
        }
    }
    //-------------------- homestay --------------------

    protected function findModel($id)
    {
        if (($model = CommunityImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
