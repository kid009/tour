<?php

namespace backend\controllers;

use Yii;
use app\models\Place;
use app\models\PlaceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class PlaceController extends Controller
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
        $searchModel = new PlaceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('place')
                ->innerJoin('community', 'community.community_id = place.community_id')
                ->innerJoin('place_group', 'place_group.place_group_id = place.place_group_id')
                ->where(['place_id' => $id])
                ->all();
                
        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $model = new Place();
        
        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->place_image_cover = Yii::$app->Upload->Importimage($model, 'place', 'uploads/community/'.$model->community_id.'/place/', 'place_image_cover');
            $model->place_contact_person_image = Yii::$app->Upload->Importimage($model, 'place', 'uploads/community/'.$model->community_id.'/place/', 'place_contact_person_image');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', '???????????????????????????????????????????????????????????????.');
                
                return $this->redirect(['index', 'id' => $model->place_id]);
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
        
        $image_old = $model->place_image_cover;
        $image_old_person = $model->place_contact_person_image;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            //upload image    
            $model->place_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'place', 'uploads/community/'.$model->community_id.'/place/','place_image_cover');
            $model->place_contact_person_image = Yii::$app->Upload->Updateimage($image_old_person, $model, 'place', 'uploads/community/'.$model->community_id.'/place/','place_contact_person_image');
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', '?????????????????????????????????'.$model->place_name.'???????????????????????????.');
                
                return $this->redirect(['index', 'id' => $model->place_id]);
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
            @unlink(Yii::getAlias('@webroot/uploads/community/'.$model->community_id.'/place/'.$model->place_image_cover));
        }
        
        if($model->delete()){

            $user = $session['user_login'];
            $date = Yii::$app->formatter->asDatetime(time());
            $request = Yii::$app->request->queryString;
            
            Yii::$app->db->createCommand("
            INSERT INTO public.bb_user_log(log_user, log_url, log_date)
            VALUES ('$user', '$request', '$date');
            ")->execute();
            
            $session->setFlash('message', '???????????????????????????????????????????????????.');
            
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Place::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
