<?php

namespace backend\controllers;

use Yii;
use app\models\ResearchOutputApply;
use app\models\ResearchPathofOutputApply;
// use app\models\ResearcherResearchCommunity;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\data\SqlDataProvider;
//get address
use yii\helpers\Json;
use app\models\Amphur;
use app\models\Tambon;

class ResearchOutputApplyController extends Controller
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

        $session = new Session();
        $session->open();

        $userLogin = $session['user_login'];

        if (!empty($_POST)) {
            $output_apply_group_id = $_POST["output_apply_group_id"];
            $tourism_product_id = $_POST["tourism_product_id"];
            $innovation_id = $_POST["innovation_id"];

            $dataProvider = new SqlDataProvider([
                'sql' => "SELECT 
                researcher_output_apply.researcher_output_apply_id
                , researcher_output_apply.researcher_output_apply_group_id
                , researcher_path_of_output_apply.researcher_tourism_product_id
                , researcher_path_of_output_apply.researcher_innovation_id
                , researcher_output_apply_group_name
                , researcher_output_apply_name
                , researcher_output_apply_image_cover
                , researcher_tourism_product_name
                , researcher_innovation_name
              FROM researcher_output_apply
              inner join researcher_output_apply_group on researcher_output_apply.researcher_output_apply_group_id = researcher_output_apply_group.researcher_output_apply_group_id
              left join researcher_path_of_output_apply on researcher_output_apply.researcher_output_apply_id = researcher_path_of_output_apply.researcher_output_apply_id
              left join researcher_tourism_product on researcher_path_of_output_apply.researcher_tourism_product_id = researcher_tourism_product.researcher_tourism_product_id
              left join researcher_innovation on researcher_path_of_output_apply.researcher_innovation_id = researcher_innovation.researcher_innovation_id
              where cast(researcher_output_apply.researcher_output_apply_group_id as varchar) like '%$output_apply_group_id%'
                or cast(researcher_path_of_output_apply.researcher_tourism_product_id as varchar) like '%$tourism_product_id%'
                or cast(researcher_path_of_output_apply.researcher_innovation_id as varchar) like '%$innovation_id%'
                and researcher_output_apply.create_by = '$userLogin'
              order by researcher_output_apply.update_date desc",
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $dataProvider = new SqlDataProvider([
                'sql' => "SELECT researcher_output_apply.researcher_output_apply_id, researcher_output_apply_group_name, researcher_output_apply_name, researcher_output_apply_image_cover
                , researcher_tourism_product_name, researcher_innovation_name
                FROM researcher_output_apply
                left join researcher_output_apply_group on researcher_output_apply.researcher_output_apply_group_id = researcher_output_apply_group.researcher_output_apply_group_id
                left join researcher_path_of_output_apply on researcher_output_apply.researcher_output_apply_id = researcher_path_of_output_apply.researcher_output_apply_id
                left join researcher_tourism_product on researcher_path_of_output_apply.researcher_tourism_product_id = researcher_tourism_product.researcher_tourism_product_id
                left join researcher_innovation on researcher_path_of_output_apply.researcher_innovation_id = researcher_innovation.researcher_innovation_id
                where researcher_output_apply.create_by = '$userLogin'
                order by researcher_output_apply.update_date desc",
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    // public function actionView($id)
    // {
    //     $model = $this->findModel($id);

    //     return $this->render('view', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        $model = new ResearchOutputApply();
        $modelPathofOutputApply = new ResearchPathofOutputApply();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->researcher_output_apply_image_cover = Yii::$app->Upload->Importimage($model, 'researcher_outputApply', 'uploads/research/outputApply/', 'researcher_output_apply_image_cover');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                $modelPathofOutputApply->researcher_output_apply_id = $model->researcher_output_apply_id;

                $modelPathofOutputApply->researcher_tourism_product_id = $_POST['ResearchPathofOutputApply']['researcher_tourism_product_id'];

                $modelPathofOutputApply->researcher_innovation_id = $_POST['ResearchPathofOutputApply']['researcher_innovation_id'];

                $modelPathofOutputApply->create_by = $session['user_login'];
                $modelPathofOutputApply->create_date = Yii::$app->formatter->asDatetime(time());

                $modelPathofOutputApply->update_by = $session['user_login'];
                $modelPathofOutputApply->update_date = Yii::$app->formatter->asDatetime(time());

                $modelPathofOutputApply->save();

                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelPathofOutputApply' => $modelPathofOutputApply,
            'amphur' => [],
            'tambon' => [],
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelPathofOutputApply = ResearchPathofOutputApply::find()->where(['researcher_output_apply_id' => $id])->one();

        $session = new Session();
        $session->open();

        $image_old = $model->researcher_output_apply_image_cover;

        $amphur = ArrayHelper::map($this->getAmphur($model->province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($model->amphur_id), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //save image
            $model->researcher_output_apply_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'researcher_outputApply', 'uploads/research/outputApply/', 'researcher_output_apply_image_cover');

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                $modelPathofOutputApply->researcher_tourism_product_id = $_POST['ResearchPathofOutputApply']['researcher_tourism_product_id'];

                $modelPathofOutputApply->researcher_innovation_id = $_POST['ResearchPathofOutputApply']['researcher_innovation_id'];

                $modelPathofOutputApply->update_by = $session['user_login'];
                $modelPathofOutputApply->update_date = Yii::$app->formatter->asDatetime(time());

                $modelPathofOutputApply->save();

                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelPathofOutputApply' => $modelPathofOutputApply,
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
            @unlink(Yii::getAlias('@webroot/uploads/research/outputApply/' . $model->researcher_output_apply_image_cover));
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
        if (($model = ResearchOutputApply::findOne($id)) !== null) {
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
