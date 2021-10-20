<?php

namespace backend\controllers;

use Yii;
use app\models\ResearcherResearch;
use app\models\ResearcherResearchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\ResearcherResearchCommunity;

class ResearcherResearchController extends Controller
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
        $searchModel = new ResearcherResearchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        // $session = new Session();
        // $session->open();

        // $userLoginAdmin = $session['user_login'];

        // if (!empty($_POST)) {
        //     $community_id = $_POST["community_id"];

        //     $dataProvider = new SqlDataProvider([
        //         'sql' => "SELECT researcher_research.researcher_research_id, community_name, research_name, research_budget,researcher_research.create_by
        //         FROM researcher_research
        //         left JOIN researcher_research_community ON researcher_research.researcher_research_id = researcher_research_community.researcher_research_id
        //         left JOIN community ON researcher_research_community.community_id = community.community_id
        //         WHERE CAST(researcher_research_community.community_id AS VARCHAR) LIKE '%$community_id%' 
        //           and researcher_research.create_by like '%$userLoginAdmin%' ",
        //     ]);

        //     return $this->render('index', [
        //         'dataProvider' => $dataProvider,
        //     ]);
        // } else {

        //     $dataProvider = new SqlDataProvider([
        //         'sql' => "SELECT researcher_research.researcher_research_id, community_name, research_name, research_budget, researcher_research.create_by
        //         FROM researcher_research
        //         left JOIN researcher_research_community ON researcher_research.researcher_research_id = researcher_research_community.researcher_research_id
        //         left JOIN community ON researcher_research_community.community_id = community.community_id
        //         where researcher_research.create_by like '%$userLoginAdmin%' ",

        //     ]);

        //     return $this->render('index', [
        //         'dataProvider' => $dataProvider,
        //     ]);
        // }
    }

    public function actionCreate()
    {
        $model = new ResearcherResearch();
        $modelResearchCommunity = new ResearcherResearchCommunity();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if(isset($_POST['research_user_bussiness_id'])){
                $model->research_user_bussiness_id = implode(",", $_POST['research_user_bussiness_id']);
            }

            if(isset($_POST['research_user_community_id'])){
                $model->research_user_community_id = implode(",", $_POST['research_user_community_id']);
            }
            
            if(isset($_POST['research_user_tourism_id'])){
                $model->research_user_tourism_id = implode(",", $_POST['research_user_tourism_id']);
            }

            if(isset($_POST['research_user_research_id'])){
                $model->research_user_research_id = implode(",", $_POST['research_user_research_id']);
            }
            
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
            'modelResearchCommunity' => $modelResearchCommunity,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);     

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            if(isset($_POST['research_user_bussiness_id'])){
                $model->research_user_bussiness_id = implode(",", $_POST['research_user_bussiness_id']);
            }

            if(isset($_POST['research_user_community_id'])){
                $model->research_user_community_id = implode(",", $_POST['research_user_community_id']);
            }
            
            if(isset($_POST['research_user_tourism_id'])){
                $model->research_user_tourism_id = implode(",", $_POST['research_user_tourism_id']);
            }

            if(isset($_POST['research_user_research_id'])){
                $model->research_user_research_id = implode(",", $_POST['research_user_research_id']);
            }

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
            }
        }
        else{
            $research_user_bussiness_id = explode(",", $model->research_user_bussiness_id);
            $research_user_community_id = explode(",", $model->research_user_community_id);
            $research_user_tourism_id = explode(",", $model->research_user_tourism_id);
            $research_user_research_id = explode(",", $model->research_user_research_id);

            return $this->render('update', [
                'model' => $model,
                'research_user_bussiness_id' => $research_user_bussiness_id,
                'research_user_community_id' => $research_user_community_id,
                'research_user_tourism_id' => $research_user_tourism_id,
                'research_user_research_id' => $research_user_research_id,
            ]);
        }

        
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $session = new Session();
        $session->open();

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
        if (($model = ResearcherResearch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function deleteOldData($model, $column, $table)
    {
        //delete old user_researcher 
        $data = [];
        foreach ($model as $value) {
            array_push($data, $value["$column"]);
        }

        foreach ($data as $id) {
            Yii::$app->db->createCommand("
                DELETE FROM {$table}
                WHERE researcher_research_id = $researcher_research_id and {$column} = $id 
            ")->execute();
        }
    }

}
