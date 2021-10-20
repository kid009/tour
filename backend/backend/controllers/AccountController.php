<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\UserSearch;
use app\models\UserRole;
use app\models\UserResearcher;
use app\models\UserBussiness;
use app\models\UserTourism;
use app\models\Role;
use yii\web\Session;
use yii\helpers\ArrayHelper;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;
//get address
use yii\helpers\Json;
use app\models\Amphur;
use app\models\Tambon;

class AccountController extends Controller
{
    public function actionLoginhome()
    {
        $model = new User();

        if (!empty($_GET)) {

            $user_login = Yii::$app->request->get('user');
            $user_password = Yii::$app->request->get('password');

            $user = User::findBySql("
            select user_id, user_login, user_password 
            from bb_user 
            where user_login = '$user_login' and is_active = 'Y'
            ")->all();

            foreach ($user as $value) {
                if (Yii::$app->getSecurity()->validatePassword($user_password, $value['user_password'])) {
                    $session = new Session;
                    $session->open();
                    $session['user_id'] = $value['user_id'];
                    $session['user_login'] = $value['user_login'];
                    $user_id = $value['user_id'];

                    $redirect = Yii::$app->db->createCommand("
                        select redirect, role_name from bb_user_role
                        inner join bb_role on bb_user_role.role_id = bb_role.role_id
                        where user_id = $user_id
                    ")->queryAll();

                    $page = $redirect[0]['redirect'];
                    $session['role_name'] = $redirect[0]['role_name'];

                    return $this->redirect([$page]);
                } else {
                    $model = new User();
                    $model->user_login = $_POST['User']['user_login'];
                    $model->user_password = $_POST['User']['user_password'];
                }
            }
        }

        return $this->renderPartial('login', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        $model = new User();

        $session = new Session();
        $session->open();

        if (!empty($_POST)) {

            $user_login = $_POST['User']['user_login'];
            $user_password = $_POST['User']['user_password'];

            $user = User::findBySql("
            select user_id, user_login, user_password 
            from bb_user 
            where user_login = '$user_login' and is_active = 'Y'
            ")->all();

            foreach ($user as $value) {
                if (Yii::$app->getSecurity()->validatePassword($user_password, $value['user_password'])) {
                    $session = new Session;
                    $session->open();
                    $session['user_id'] = $value['user_id'];
                    $session['user_login'] = $value['user_login'];
                    $user_id = $value['user_id'];

                    $redirect = Yii::$app->db->createCommand("
                        select redirect from bb_user_role
                        inner join bb_role on bb_user_role.role_id = bb_role.role_id
                        where user_id = $user_id
                    ")->queryAll();

                    $page = $redirect[0]['redirect'];

                    $user = $session['user_login'];
                    $date = Yii::$app->formatter->asDatetime(time());
                    $request = Yii::$app->request->queryString;
        
                    Yii::$app->db->createCommand("
                    INSERT INTO public.bb_user_log(
                    log_user, log_url, log_date)
                    VALUES ('$user', '$request', '$date');
                    ")->execute();

                    return $this->redirect([$page]);
                } else {
                    $model = new User();
                    $model->user_login = $_POST['User']['user_login'];
                    $model->user_password = $_POST['User']['user_password'];
                    $session->setFlash('message', 'ชื่อหรือรหัสผ่านไม่ถูกต้อง');
                }
            }
        }

        return $this->renderPartial('login', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $session = new Session();
        $session->open();

        if (empty($session['user_id'])) {
            return $this->redirect('index.php?r=account/login');
        } else {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new User();
        $modelUserRole = new UserRole();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $password = $_POST['User']['user_password'];

            if (strlen($password) >= 8) {
                if (!ctype_upper($password) && !ctype_digit($password)) {
                    $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($password);
                    $model->user_password = $passwordHash;

                    $model->create_by = $session['user_login'];
                    $model->create_date = Yii::$app->formatter->asDatetime(time());

                    $model->update_by = $session['user_login'];
                    $model->update_date = Yii::$app->formatter->asDatetime(time());

                    if ($model->save()) {

                        $modelUserRole->user_id = $model->user_id;
                        $modelUserRole->role_id = $_POST['UserRole']['role_id'];

                        $modelUserRole->create_by = $session['user_login'];
                        $modelUserRole->create_date = Yii::$app->formatter->asDatetime(time());

                        $modelUserRole->update_by = $session['user_login'];
                        $modelUserRole->update_date = Yii::$app->formatter->asDatetime(time());

                        $modelUserRole->save();

                        $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');

                        return $this->redirect(['index']);
                    }
                }
            } 
            else {
                return $this->render('create', [
                    'model' => $model,
                    'modelUserRole' => $modelUserRole,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUserRole' => $modelUserRole,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUserRole = UserRole::find('role_id')->where(['user_id' => $id])->one();

        $passwoedOld = $model->user_password;
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $password = $_POST['User']['user_password'];

            if ($password !== $passwoedOld) {
                if (strlen($password) >= 8) {
                    if (!ctype_upper($password) && !ctype_digit($password)) {
                        $passwordHash = Yii::$app->getSecurity()->generatePasswordHash($password);
                        $model->user_password = $passwordHash;
                    }
                }
                else {
                    return $this->render('create', [
                        'model' => $model,
                        'modelUserRole' => $modelUserRole,
                    ]);
                }
            }

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                $modelUserRole->user_id = $model->user_id;
                $modelUserRole->role_id = $_POST['UserRole']['role_id'];

                $modelUserRole->update_by = $session['user_login'];
                $modelUserRole->update_date = Yii::$app->formatter->asDatetime(time());

                $modelUserRole->save();

                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
            } 
            
        }

        return $this->render('update', [
            'model' => $model,
            'modelUserRole' => $modelUserRole,
        ]);
    }

    public function actionUserDetail($id)
    {
        $model = $this->findModel($id);
        $modelUserRole = UserRole::find()->where(['user_id' => $id])->all();

        $image_old = $model->user_image_cover;
        $image_old = $model->user_image_background_cover;

        $session = new Session();
        $session->open();

        $amphur = ArrayHelper::map($this->getAmphur($model->province_id), 'id', 'name');
        $tambon = ArrayHelper::map($this->getTambon($model->amphur_id), 'id', 'name');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //upload image    
            $model->user_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'account_', 'uploads/account/','user_image_cover'); 
            $model->user_image_background_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'background_', 'uploads/background/','user_image_background_cover'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {

                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');

                return $this->redirect(['index']);
            } 
            
        }

        return $this->render('user-detail', [
            'model' => $model,
            'amphur' => $amphur,
            'tambon' => $tambon,
            'modelUserRole' => $modelUserRole,
        ]);
    }

    public function actionLogout()
    {
        $session = new Session;
        $session->open();

        $user = $session['user_login'];
        $date = Yii::$app->formatter->asDatetime(time());
        $request = Yii::$app->request->queryString;
        
        Yii::$app->db->createCommand("
        INSERT INTO public.bb_user_log(log_user, log_url, log_date)
        VALUES ('$user', '$request', '$date');
        ")->execute();

        unset($session['user_id']);
        unset($session['user_login']);

        return $this->redirect(['account/login']);
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
        if (($model = User::findOne($id)) !== null) {
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
