<?php

namespace backend\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
use yii\helpers\Json;

class ProductController extends Controller
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
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $query = new Query();
        $data = $query->select('*')->from('product')
                ->innerJoin('community', 'community.community_id = product.community_id')
                ->innerJoin('special_group', 'special_group.special_group_id = product.special_group_id')
                ->innerJoin('product_group', 'product_group.product_group_id = product.product_group_id')
                ->where(['product.product_id' => $id])
                ->all();       
        
        return $this->render('view', [
            'data' => $data,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();
        
        $session = new Session();
        $session->open();

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->product_image_cover = Yii::$app->Upload->Importimage($model, 'product', 'uploads/community/'.$model->community_id.'/product/', 'product_image_cover');

            $model->product_image_contact = Yii::$app->Upload->Importimage($model, 'product', 'uploads/community/'.$model->community_id.'/product/', 'product_image_contact');
            
            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->product_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'special_group' => [],
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();
        
        $image_old = $model->product_image_cover;
        $image_contact_old = $model->product_image_contact;
        
        $special_group = \yii\helpers\ArrayHelper::map(\app\models\SpecialGroup::find()->where(['special_group_id' => $model->special_group_id])->all(), 'special_group_id', 'special_group_name');

        if ($model->load(Yii::$app->request->post())) {
            
            //save image
            $model->product_image_cover = Yii::$app->Upload->Updateimage($image_old, $model, 'product', 'uploads/community/'.$model->community_id.'/product/', 'product_image_cover');
            
            $model->product_image_contact = Yii::$app->Upload->Updateimage($image_contact_old, $model, 'product', 'uploads/community/'.$model->community_id.'/product/', 'product_image_contact');
            
            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());
            
            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                
                return $this->redirect(['index', 'id' => $model->product_id]);
            } 
        }

        return $this->render('update', [
            'model' => $model,
            'special_group' => $special_group,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/product/').$model->product_image_cover);
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
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionGetSpecialgroup() 
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $community_id = $parents[0];
                $out = $this->getSpecialgroup($community_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function getSpecialgroup($id)
    {
        $datas = \app\models\SpecialGroup::find()->where(['community_id'=>$id])->all();
        return $this->MapData($datas,'special_group_id','special_group_name');
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
