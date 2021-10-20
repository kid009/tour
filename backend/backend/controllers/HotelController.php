<?php

namespace backend\controllers;

use Yii;
use app\models\Hotel;
use app\models\HotelSearch;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use app\models\Amphur;
use app\models\Tambon;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class HotelController extends \yii\web\Controller
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
        $searchModel = new HotelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('hotel')
            ->leftjoin('community', 'community.community_id = hotel.community_id')
            ->innerJoin('tb_province', 'tb_province.province_id = hotel.province_id')
            ->innerJoin('tb_amphur', 'tb_amphur.amphur_id = hotel.amphur_id')
            ->innerJoin('tb_tambon', 'tb_tambon.tambon_id = hotel.tambon_id')
            ->where(['hotel_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new Hotel();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //upload image
            $model->hotel_image_cover = Yii::$app->Upload->Importimage($model, 'hotel', 'uploads/community/' . $model->community_id . '/hotel/', 'hotel_image_cover');

            $model->hotel_contact_person_image = Yii::$app->Upload->Importimage($model, 'hotel', 'uploads/community/' . $model->community_id . '/hotel/', 'hotel_contact_person_image');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->hotel_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'amphur' => [],
            'tambon' => [],
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $session = new Session();
        $session->open();

        $province_id = $model->province_id;
        $amphur_id = $model->amphur_id;

        $amphur = ArrayHelper::map($this->getAmphur($province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($amphur_id), 'id', 'name');

        $image_old = $model->hotel_image_cover;
        $image_contact_old = $model->hotel_contact_person_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            //upload image    
            $model->hotel_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'hotel', 'uploads/community/' . $model->community_id . '/hotel/', 'hotel_image_cover');
            $model->hotel_contact_person_image = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'hotel', 'uploads/community/' . $model->community_id . '/hotel/', 'hotel_contact_person_image');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย');

                return $this->redirect(['index', 'id' => $model->hotel_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'amphur' => $amphur,
            'tambon' => $tambon,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $session = new Session();
        $session->open();

        if (!empty($model)) {
            @unlink(Yii::getAlias('@webroot/uploads/community/' . $model->community_id . '/hotel/' . $model->hotel_image_cover));
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
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetAmphur()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetTambon()
    {
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];

            if ($province_id != null) {
                $data = $this->getTambon($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }

        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function getAmphur($id)
    {
        $datas = Amphur::find()->where(['province_id' => $id])->all();
        return $this->MapData($datas, 'amphur_id', 'amphur_name');
    }

    public function getTambon($id)
    {
        $datas = Tambon::find()->where(['amphur_id' => $id])->all();
        return $this->MapData($datas, 'tambon_id', 'tambon_name');
    }

    public function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }
}
