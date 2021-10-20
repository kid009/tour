<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\models\RoleOperation;
use app\models\Role;
use app\models\RoleSearch;
use yii\web\Session;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class RoleController extends Controller
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
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Role();
        $modelRoleOperation = new RoleOperation();

        $session = new Session;
        $session->open();

        $operations = Yii::$app->db->createCommand("
        select operation_id, operation_name_th, level
        from bb_operation
        where is_active = 'Y'
        order by  display_order asc
        ")->queryAll();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                $roleId = $model->role_id;

                if (isset($_POST['showmenu'])) {

                    foreach ($_POST['showmenu'] as $id) {
                        $operationId = (int)$id;
                        $userLogin = $session['user_login'];;
                        $dateTime = Yii::$app->formatter->asDatetime(time());

                        Yii::$app->db->createCommand("
                        INSERT INTO public.bb_role_operation(
                        role_id, operation_id, create_by, create_date, update_by, update_date)
                        VALUES ($roleId, $operationId, '$userLogin', '$dateTime', '$userLogin', '$dateTime');
                        ")->execute();
                    }
                }
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelRoleOperation' => $modelRoleOperation,
            'operations' => $operations,

        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $role_id = $model->role_id;
        $modelRoleOperation = $this->findModelRoleOperation($role_id);

        $operations = Yii::$app->db->createCommand("
        select operation_id, operation_name_th, level
        from bb_operation
        where is_active = 'Y'
        order by  display_order asc
        ")->queryAll();

        $operationIdOld = [];
        foreach ($modelRoleOperation as $value) {
            array_push($operationIdOld, $value['operation_id']);
        }

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                //ลบข้อมูลเดิม role_id, operation_id
                foreach ($operationIdOld as $ids) {
                    //echo $ids;
                    Yii::$app->db->createCommand("
                    DELETE FROM bb_role_operation
                    WHERE role_id = $role_id and operation_id = $ids 
                    ")->execute();
                }

                if (isset($_POST['showmenu'])) {
                    foreach ($_POST['showmenu'] as $operationIDPost) {
                        $operationID = (int)$operationIDPost;
                        $userLogin = $session['user_login'];;
                        $dateTime = Yii::$app->formatter->asDatetime(time());

                        //เพิ่มข้อมูลใหม่ role_id, operation_id
                        Yii::$app->db->createCommand("
                        INSERT INTO public.bb_role_operation(
                        role_id, operation_id, create_by, create_date, update_by, update_date)
                        VALUES ($role_id, $operationID, '$userLogin', '$dateTime', '$userLogin', '$dateTime');
                        ")->execute();
                    }
                    $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'operations' => $operations,
            'role_id' => $role_id,
            'modelRoleOperation' => $modelRoleOperation,
            'operationIdOld' => $operationIdOld,
        ]);
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
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelRoleOperation($id)
    {
        if (($model = RoleOperation::findBySql("
        SELECT role_operation_id, role_id, operation_id
        FROM bb_role_operation
        where role_id = $id
        ")->all()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
