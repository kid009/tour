<?php

namespace backend\controllers;

use Yii;
use app\models\Knowhow;
use app\models\KnowhowSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class KnowhowController extends Controller
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
        $searchModel = new KnowhowSearch();
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
        $data = $query->select('*')->from('knowhow')
                ->innerjoin('knowhow_group', 'knowhow_group.knowhow_group_id = knowhow.knowhow_group_id')
                ->innerJoin('community', 'community.community_id = knowhow.community_id')
                ->where(['knowhow.knowhow_id' => $id])
                ->all();
        
        $knowhowPeople = Yii::$app->db->createCommand(
                '
                    select *
                    from knowhow_people
                    inner join knowhow on knowhow.knowhow_id = knowhow_people.knowhow_id
                    inner join people on people.people_id = knowhow_people.people_id
                    where people.community_id = '.$model->community_id.' and knowhow.knowhow_id = '.$model->knowhow_id.'
                '
                )->queryAll();
        
        return $this->render('view', [
            'model' => $model,
            'data' => $data,
            'knowhowPeople' => $knowhowPeople,
            'n' => 1,
        ]);
    }

    public function actionCreate()
    {
        $model = new Knowhow();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->knowhow_image_cover = Yii::$app->Upload->Importimage($model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_image_cover');

            $model->knowhow_image_contact = Yii::$app->Upload->Importimage($model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_image_contact');

            $model->knowhow_innovation_image = Yii::$app->Upload->Importimage($model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_innovation_image');

            $model->knowhow_technology_image = Yii::$app->Upload->Importimage($model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_technology_image');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->knowhow_id]);
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
        
        $image_old = $model->knowhow_image_cover;
        $image_contact_old = $model->knowhow_image_contact;
        $image_innovation_old = $model->knowhow_innovation_image;
        $image_technology_old = $model->knowhow_technology_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->knowhow_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_image_cover'); 
            
            $model->knowhow_image_contact = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_image_contact');

            $model->knowhow_innovation_image = Yii::$app->Upload->Updateimage($image_innovation_old, $model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_innovation_image'); 
            
            $model->knowhow_technology_image = Yii::$app->Upload->Updateimage($image_technology_old, $model, 'knowhow', 'uploads/community/'.$model->community_id.'/knowhow/', 'knowhow_technology_image');
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->knowhow_id]);
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
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/knowhow/'.$model->knowhow_image_cover));
        }

        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/knowhow/'.$model->knowhow_image_contact));
        }

        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/knowhow/'.$model->knowhow_innovation_image));
        }

        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/knowhow/'.$model->knowhow_technology_image));
        }
        
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
        if (($model = Knowhow::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
