<?php

namespace backend\controllers;

use Yii;
use app\models\SpecialGroup;
use app\models\SpecialGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class SpecialGroupController extends Controller
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
        $searchModel = new SpecialGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = new Query();
        $data = $query->select('*')->from('special_group')
                ->innerJoin('community', 'community.community_id = special_group.community_id')
                ->where(['special_group.special_group_id' => $id])
                ->all();       
        
        $specialGroupPeople = Yii::$app->db->createCommand(
                                '
                                    select *
                                    from special_group_people
                                    inner join special_group on special_group.special_group_id = special_group_people.special_group_id
                                    inner join people on people.people_id = special_group_people.people_id
                                    where special_group.community_id = '.$model->community_id.' and special_group.special_group_id = '.$model->special_group_id.'
                                '
                                )->queryAll();
        
        return $this->render('view', [
            'data' => $data,
            'model' => $model,
            'specialGroupPeople' => $specialGroupPeople,
        ]);
    }

    public function actionCreate()
    {
        $model = new SpecialGroup();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {     
            
            //upload image
            $model->special_group_image_cover = Yii::$app->Upload->Importimage($model, 'special_group', 'uploads/community/' . $model->community_id . '/special_group/', 'special_group_image_cover');

            $model->special_group_image_contact = Yii::$app->Upload->Importimage($model, 'special_group', 'uploads/community/' . $model->community_id . '/special_group/', 'special_group_image_contact');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->special_group_id]);
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

        $image_old = $model->special_group_image_cover;
        $image_contact_old = $model->special_group_image_contact;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //upload image    
            $model->special_group_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'special_group', 'uploads/community/' . $model->community_id . '/special_group/', 'special_group_image_cover');

            $model->special_group_image_contact = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'special_group', 'uploads/community/' . $model->community_id . '/special_group/', 'special_group_image_contact');
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->special_group_id]);
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
        
        if($model->delete()){

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
        if (($model = SpecialGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
