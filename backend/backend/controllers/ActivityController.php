<?php

namespace backend\controllers;

use Yii;
use app\models\Activity;
use app\models\ActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActivityController extends Controller
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
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('activity')
            ->innerJoin('community', 'community.community_id = activity.community_id')
            ->innerJoin('activity_group', 'activity_group.activity_group_id = activity.activity_group_id')
            //->innerJoin('activity_sub', 'activity_sub.activity_id = activity.activity_id')
            ->where(['activity.activity_id' => $id])
            ->all();

        $activitySubQuery = new Query();
        $activitySub = $activitySubQuery->select('*')
            ->from('activity_sub')
            ->innerJoin('activity', 'activity_sub.activity_id = activity.activity_id')
            ->where(['activity.activity_id' => $id])
            ->orderBy('activity_sub_order asc')
            ->all();

        $activityPlaceQuery = new Query();
        $activityPlace = $activityPlaceQuery->select('*')
            ->from('activity_place')
            ->innerJoin('place', 'place.place_id = activity_place.place_id')
            ->innerJoin('activity', 'activity.activity_id = activity_place.activity_id')
            ->where(['activity_place.activity_id' => $id])
            ->all();

        $activityNatureQuery = new Query();
        $activityNature = $activityNatureQuery->select('*')
            ->from('activity_nature')
            ->innerJoin('nature', 'nature.nature_id = activity_nature.nature_id')
            ->innerJoin('activity', 'activity.activity_id = activity_nature.activity_id')
            ->where(['activity_nature.activity_id' => $id])
            ->all();

        $activityHomestayQuery = new Query();
        $activityHomestay = $activityHomestayQuery->select('*')
            ->from('activity_homestay')
            ->innerJoin('homestay', 'homestay.homestay_id = activity_homestay.homestay_id')
            ->innerJoin('activity', 'activity.activity_id = activity_homestay.activity_id')
            ->where(['activity_homestay.activity_id' => $id])
            ->all();

        $activitySpecialGroupQuery = new Query();
        $activitySpecialGroup = $activitySpecialGroupQuery->select('*')
            ->from('activity_special_group')
            ->innerJoin('special_group', 'special_group.special_group_id = activity_special_group.special_group_id')
            ->innerJoin('activity', 'activity.activity_id = activity_special_group.activity_id')
            ->where(['activity_special_group.activity_id' => $id])
            ->all();

        //save order activity_sub
        if (isset($_POST['update'])) {
            foreach ($_POST['positions'] as $position) {
                $index = $position[0];
                $newPosition = $position[1];

                Yii::$app->db->createCommand(
                    "
                    UPDATE activity_sub
                    SET activity_sub_order = $newPosition
                    WHERE activity_sub_id = $index
                "
                )->execute();
            }
            exit('success');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
            'activitySub' => $activitySub,
            'activityPlace' => $activityPlace,
            'activityNature' => $activityNature,
            'activityHomestay' => $activityHomestay,
            'activitySpecialGroup' => $activitySpecialGroup,
            'n' => 1,
        ]);
    }

    public function actionCreate()
    {
        $model = new Activity();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->activity_image_cover = Yii::$app->Upload->Importimage($model, 'activity', 'uploads/community/' . $model->community_id . '/activity/', 'activity_image_cover');

            $model->activity_contact_image = Yii::$app->Upload->Importimage($model, 'activity', 'uploads/community/' . $model->community_id . '/activity/', 'activity_contact_image');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->activity_id]);
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

        $image_old = $model->activity_image_cover;
        $image_contact_old = $model->activity_contact_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //upload image    
            $model->activity_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'activity', 'uploads/community/' . $model->community_id . '/activity/', 'activity_image_cover');

            $model->activity_contact_image = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'activity', 'uploads/community/' . $model->community_id . '/activity/', 'activity_contact_image');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย');

                return $this->redirect(['index', 'id' => $model->activity_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/activity/') . $model->activity_image_cover);
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
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}