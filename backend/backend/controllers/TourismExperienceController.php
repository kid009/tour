<?php

namespace backend\controllers;

use app\models\TourismExperience;
use app\models\TourismExperienceSearch;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;
//check unique
use yii\web\Session;
use yii\widgets\ActiveForm;
//get address
use yii\helpers\Json;
use app\models\Amphur;
use app\models\Tambon;

class TourismExperienceController extends Controller
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
        $searchModel = new TourismExperienceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('tourism_experience')
            ->innerjoin('tourism_experience_group', 'tourism_experience_group.tourism_experience_group_id = tourism_experience.tourism_experience_group_id')
            ->where(['tourism_experience.tourism_experience_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new TourismExperience();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->tourism_experience_image_cover = Yii::$app->Upload->Importimage($model, 'tourism_experience', 'uploads/tourism/experience/', 'tourism_experience_image_cover');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->tourism_experience_id]);
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

        $image_old = $model->tourism_experience_image_cover;

        $amphur = ArrayHelper::map($this->getAmphur($model->province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($model->amphur_id), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //save image
            $model->tourism_experience_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'tourism_experience', 'uploads/tourism/experience/', 'tourism_experience_image_cover');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->tourism_experience_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/tourism/experience/' . $model->tourism_experience_image_cover));
        }

        if ($model->delete()) {
            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');

            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = TourismExperience::findOne($id)) !== null) {
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
