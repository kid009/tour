<?php

namespace backend\controllers;

use Yii;
use app\models\Entrepreneur;
use app\models\EntrepreneurSearch;
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

class EnterpreneurController extends \yii\web\Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

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
        $searchModel = new EntrepreneurSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('entrepreneur')
            ->innerJoin('entrepreneur_group', 'entrepreneur_group.entrepreneur_group_id = entrepreneur.entrepreneur_group_id')
            ->innerJoin('province', 'province.province_id = entrepreneur.province_id')
            ->innerJoin('amphur', 'amphur.amphur_id = entrepreneur.amphur_id')
            ->innerJoin('tambon', 'tambon.tambon_id = entrepreneur.tambon_id')
            ->where(['entrepreneur_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new Entrepreneur();
  
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {

            //upload image
            $model->entrepreneur_image = Yii::$app->Upload->Importimage($model, 'entrepreneur', 'uploads/entrepreneur/', 'entrepreneur_image');


            $model->create_by = $session['user_login'];
            $model->create_date = date("Y-m-d H:i:s");

            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->entrepreneur_id]);
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

        $province_id = $model->province_id;
        $amphur_id = $model->amphur_id;

        $image_old = $model->entrepreneur_image;

        $amphur = ArrayHelper::map($this->getAmphur($province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($amphur_id), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //upload image
            $model->entrepreneur_image = Yii::$app->Upload->Updateimage($image_old, $model, 'entrepreneur', 'uploads/entrepreneur/', 'entrepreneur_image');

            $model->update_by = $session['user_login'];
            $model->update_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index', 'id' => $model->entrepreneur_id]);
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

        if ($model->delete()) {
            $session->setFlash('message', 'ลบข้อมูลเรียบร้อย.');

            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Entrepreneur::findOne($id)) !== null) {
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
