<?php

namespace backend\controllers;

use Yii;
use app\models\Researchknowhow;
use app\models\ResearchImage;
use app\models\ResearchExperience;
use app\models\ResearchInnovation;
use app\models\ResearchTechnology;
use app\models\ResearchTourismProduct;
use app\models\ResearchOutputApply;
use yii\web\Controller;
use yii\web\Session;
//check unique
use yii\web\Response;
use yii\widgets\ActiveForm;

class ResearchImageController extends Controller
{
    // ---------- Knowhow ----------
    public function actionKnowhowIndex($researcher_knowhow_id)
    {
        $knowhow = Researchknowhow::findOne($researcher_knowhow_id);

        $researchKnowhowImages = ResearchImage::find()->where(['ref_id' => $researcher_knowhow_id, 'research_type_id' => 1])->all();
        //var_dump($researchKnowhowImages);

        return $this->render('knowhow/index', [
            'knowhow' => $knowhow,
            'researcher_knowhow_id' => $researcher_knowhow_id,
            'researchKnowhowImages' => $researchKnowhowImages
        ]);
    }

    public function actionKnowhowCreate($researcher_knowhow_id)
    {
        $knowhow = Researchknowhow::findOne($researcher_knowhow_id);
        $model = new ResearchImage();

        $research_type_id = Yii::$app->db->createCommand("select research_type_id from researcher_type where research_type_name = 'knowhow' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->research_type_id = $research_type_id[0]['research_type_id'];
            $model->ref_id = $researcher_knowhow_id;

            //save image
            $model->research_image_file = Yii::$app->Upload->Importimage($model, 'researcher_knowhow', 'uploads/research/knowhow/', 'research_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['knowhow-index', 'researcher_knowhow_id' => $researcher_knowhow_id]);
            }
        }

        return $this->render('knowhow/create', [
            'model' => $model,
            'knowhow' => $knowhow,
            'researcher_knowhow_id' => $researcher_knowhow_id,
        ]);
    }

    public function actionKnowhowUpdate($researcher_knowhow_id, $research_image_id)
    {
        $knowhow = Researchknowhow::findOne($researcher_knowhow_id);
        $model = ResearchImage::findOne($research_image_id);

        $session = new Session();
        $session->open();  
        
        $image_old = $model->research_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->ref_id = $researcher_knowhow_id;

            $model->research_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'researcher_knowhow', 'uploads/research/knowhow/', 'research_image_file'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['knowhow-index', 'researcher_knowhow_id' => $researcher_knowhow_id]);
            }
        }

        return $this->render('knowhow/update', [
            'model' => $model,
            'knowhow' => $knowhow,
            'researcher_knowhow_id' => $researcher_knowhow_id,
        ]);
    }

    public function actionKnowhowDelete($researcher_knowhow_id, $research_image_id)
    {
        $model = ResearchImage::findOne($research_image_id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/research/knowhow/').$model->research_image_file);
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

            return $this->redirect(['knowhow-index', 'researcher_knowhow_id' => $researcher_knowhow_id]);
        } 
    }
    // ---------- Knowhow ----------

    // ---------- Experience ----------
    public function actionExperienceIndex($researcher_experience_id)
    {
        $experience = ResearchExperience::findOne($researcher_experience_id);

        $researchExperienceImages = ResearchImage::find()->where(['ref_id' => $researcher_experience_id, 'research_type_id' => 2])->all();
        //var_dump($researchKnowhowImages);

        return $this->render('experience/index', [
            'experience' => $experience,
            'researcher_experience_id' => $researcher_experience_id,
            'researchExperienceImages' => $researchExperienceImages
        ]);
    }

    public function actionExperienceCreate($researcher_experience_id)
    {
        $experience = ResearchExperience::findOne($researcher_experience_id);
        $model = new ResearchImage();

        $research_type_id = Yii::$app->db->createCommand("select research_type_id from researcher_type where research_type_name = 'experience' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->research_type_id = $research_type_id[0]['research_type_id'];
            $model->ref_id = $researcher_experience_id;

            //save image
            $model->research_image_file = Yii::$app->Upload->Importimage($model, 'researcher_experience', 'uploads/research/experience/', 'research_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['experience-index', 'researcher_experience_id' => $researcher_experience_id]);
            }
        }

        return $this->render('experience/create', [
            'model' => $model,
            'experience' => $experience,
            'researcher_experience_id' => $researcher_experience_id,
        ]);
    }

    public function actionExperienceUpdate($researcher_experience_id, $research_image_id)
    {
        $experience = ResearchExperience::findOne($researcher_experience_id);
        $model = ResearchImage::findOne($research_image_id);

        $session = new Session();
        $session->open();  
        
        $image_old = $model->research_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->ref_id = $researcher_experience_id;

            $model->research_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'researcher_experience', 'uploads/research/experience/', 'research_image_file'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['experience-index', 'researcher_experience_id' => $researcher_experience_id]);
            }
        }

        return $this->render('experience/update', [
            'model' => $model,
            'experience' => $experience,
            'researcher_experience_id' => $researcher_experience_id,
        ]);
    }

    public function actionExperienceDelete($researcher_experience_id, $research_image_id)
    {
        $model = ResearchImage::findOne($research_image_id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/research/experience/').$model->research_image_file);
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

            return $this->redirect(['experience-index', 'researcher_experience_id' => $researcher_experience_id]);
        } 
    }

    // ---------- Experience ----------

    // ---------- Technology ----------
    public function actionTechnologyIndex($researcher_technology_id)
    {
        $technology = ResearchTechnology::findOne($researcher_technology_id);

        $researchTechnologyImages = ResearchImage::find()->where(['ref_id' => $researcher_technology_id, 'research_type_id' => 3])->all();
        //var_dump($researchKnowhowImages);

        return $this->render('technology/index', [
            'technology' => $technology,
            'researcher_technology_id' => $researcher_technology_id,
            'researchTechnologyImages' => $researchTechnologyImages
        ]);
    }

    public function actionTechnologyCreate($researcher_technology_id)
    {
        $technology = ResearchTechnology::findOne($researcher_technology_id);
        $model = new ResearchImage();

        $research_type_id = Yii::$app->db->createCommand("select research_type_id from researcher_type where research_type_name = 'technology' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->research_type_id = $research_type_id[0]['research_type_id'];
            $model->ref_id = $researcher_technology_id;

            //save image
            $model->research_image_file = Yii::$app->Upload->Importimage($model, 'researcher_technology', 'uploads/research/technology/', 'research_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['technology-index', 'researcher_technology_id' => $researcher_technology_id]);
            }
        }

        return $this->render('technology/create', [
            'model' => $model,
            'technology' => $technology,
            'researcher_technology_id' => $researcher_technology_id,
        ]);
    }

    public function actionTechnologyUpdate($researcher_technology_id, $research_image_id)
    {
        $technology = ResearchTechnology::findOne($researcher_technology_id);
        $model = ResearchImage::findOne($research_image_id);

        $session = new Session();
        $session->open();  
        
        $image_old = $model->research_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->ref_id = $researcher_technology_id;

            $model->research_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'researcher_technology', 'uploads/research/technology/', 'research_image_file'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['technology-index', 'researcher_technology_id' => $researcher_technology_id]);
            }
        }

        return $this->render('technology/update', [
            'model' => $model,
            'technology' => $technology,
            'researcher_technology_id' => $researcher_technology_id,
        ]);
    }

    public function actionTechnologyDelete($researcher_technology_id, $research_image_id)
    {
        $model = ResearchImage::findOne($research_image_id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/research/technology/').$model->research_image_file);
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

            return $this->redirect(['technology-index', 'researcher_technology_id' => $researcher_technology_id]);
        } 
    }
    // ---------- Technology ---------- 

    // ---------- Innovation ----------
    public function actionInnovationIndex($researcher_innovation_id)
    {
        $innovation = ResearchInnovation::findOne($researcher_innovation_id);

        $researchInnovationImages = ResearchImage::find()->where(['ref_id' => $researcher_innovation_id, 'research_type_id' => 4])->all();
        //var_dump($researchKnowhowImages);

        return $this->render('innovation/index', [
            'innovation' => $innovation,
            'researcher_innovation_id' => $researcher_innovation_id,
            'researchInnovationImages' => $researchInnovationImages
        ]);
    }

    public function actionInnovationCreate($researcher_innovation_id)
    {
        $innovation = ResearchInnovation::findOne($researcher_innovation_id);
        $model = new ResearchImage();

        $research_type_id = Yii::$app->db->createCommand("select research_type_id from researcher_type where research_type_name = 'innovation' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->research_type_id = $research_type_id[0]['research_type_id'];
            $model->ref_id = $researcher_innovation_id;

            //save image
            $model->research_image_file = Yii::$app->Upload->Importimage($model, 'researcher_innovation', 'uploads/research/innovation/', 'research_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['innovation-index', 'researcher_innovation_id' => $researcher_innovation_id]);
            }
        }

        return $this->render('innovation/create', [
            'model' => $model,
            'innovation' => $innovation,
            'researcher_innovation_id' => $researcher_innovation_id,
        ]);
    }

    public function actionInnovationUpdate($researcher_innovation_id, $research_image_id)
    {
        $innovation = ResearchInnovation::findOne($researcher_innovation_id);
        $model = ResearchImage::findOne($research_image_id);

        $session = new Session();
        $session->open();  
        
        $image_old = $model->research_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->ref_id = $researcher_innovation_id;

            $model->research_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'researcher_innovation', 'uploads/research/innovation/', 'research_image_file'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['innovation-index', 'researcher_innovation_id' => $researcher_innovation_id]);
            }
        }

        return $this->render('innovation/update', [
            'model' => $model,
            'innovation' => $innovation,
            'researcher_innovation_id' => $researcher_innovation_id,
        ]);
    }

    public function actionInnovationDelete($researcher_innovation_id, $research_image_id)
    {
        $model = ResearchImage::findOne($research_image_id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/research/innovation/').$model->research_image_file);
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

            return $this->redirect(['innovation-index', 'researcher_innovation_id' => $researcher_innovation_id]);
        } 
    }
    // ---------- Innovation ----------

    // ---------- Tourism Product ----------
    public function actionTourismProductIndex($researcher_tourism_product_id)
    {
        $tourism = ResearchTourismProduct::findOne($researcher_tourism_product_id);

        $researchImages = ResearchImage::find()->where(['ref_id' => $researcher_tourism_product_id, 'research_type_id' => 5])->all();
        //var_dump($researchKnowhowImages);

        return $this->render('tourism-product/index', [
            'tourism' => $tourism,
            'researcher_tourism_product_id' => $researcher_tourism_product_id,
            'researchImages' => $researchImages
        ]);
    }

    public function actionTourismProductCreate($researcher_tourism_product_id)
    {
        $tourism = ResearchTourismProduct::findOne($researcher_tourism_product_id);
        $model = new ResearchImage();

        $research_type_id = Yii::$app->db->createCommand("select research_type_id from researcher_type where research_type_name = 'tourism product' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->research_type_id = $research_type_id[0]['research_type_id'];
            $model->ref_id = $researcher_tourism_product_id;

            //save image
            $model->research_image_file = Yii::$app->Upload->Importimage($model, 'researcher_tourism_product', 'uploads/research/tourism_product/', 'research_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['tourism-product-index', 'researcher_tourism_product_id' => $researcher_tourism_product_id]);
            }
        }

        return $this->render('tourism-product/create', [
            'model' => $model,
            'tourism' => $tourism,
            'researcher_tourism_product_id' => $researcher_tourism_product_id,
        ]);
    }

    public function actionTourismProductUpdate($researcher_tourism_product_id, $research_image_id)
    {
        $tourism = ResearchTourismProduct::findOne($researcher_tourism_product_id);
        $model = ResearchImage::findOne($research_image_id);

        $session = new Session();
        $session->open();  
        
        $image_old = $model->research_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->ref_id = $researcher_tourism_product_id;

            $model->research_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'researcher_tourism_product', 'uploads/research/tourism_product/', 'research_image_file'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['tourism-product-index', 'researcher_tourism_product_id' => $researcher_tourism_product_id]);
            }
        }

        return $this->render('tourism-product/update', [
            'model' => $model,
            'tourism' => $tourism,
            'researcher_tourism_product_id' => $researcher_tourism_product_id,
        ]);
    }

    public function actionTourismProductDelete($researcher_tourism_product_id, $research_image_id)
    {
        $model = ResearchImage::findOne($research_image_id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/research/tourism_product/').$model->research_image_file);
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

            return $this->redirect(['tourism-product-index', 'researcher_tourism_product_id' => $researcher_tourism_product_id]);
        } 
    }
    // ---------- Tourism Product ----------

    // ---------- Output Apply ----------
    public function actionOutputApplyIndex($id)
    {
        $value = ResearchOutputApply::findOne($id);

        $images = ResearchImage::find()->where(['ref_id' => $id, 'research_type_id' => 6])->all();
        //var_dump($researchKnowhowImages);

        return $this->render('output-apply/index', [
            'value' => $value,
            'id' => $id,
            'images' => $images
        ]);
    }

    public function actionOutputApplyCreate($id)
    {
        $value = ResearchOutputApply::findOne($id);
        $model = new ResearchImage();

        $research_type_id = Yii::$app->db->createCommand("select research_type_id from researcher_type where research_type_name = 'output' ")->queryAll();

        $session = new Session();
        $session->open();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->research_type_id = $research_type_id[0]['research_type_id'];
            $model->ref_id = $id;

            //save image
            $model->research_image_file = Yii::$app->Upload->Importimage($model, 'research_output_apply', 'uploads/research/outputApply/', 'research_image_file');

            $model->create_by = $session['user_login'];
            $model->create_date = Yii::$app->formatter->asDatetime(time());

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if ($model->save()) {
                $session->setFlash('message', 'บันทึกข้อมูลเรียบร้อย.');
                return $this->redirect(['output-apply-index', 'id' => $id]);
            }
        }

        return $this->render('output-apply/create', [
            'model' => $model,
            'value' => $value,
            'id' => $id,
        ]);
    }

    public function actionOutputApplyUpdate($id, $research_image_id)
    {
        $value = ResearchOutputApply::findOne($id);
        $model = ResearchImage::findOne($research_image_id);

        $session = new Session();
        $session->open();  
        
        $image_old = $model->research_image_file;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->ref_id = $id;

            $model->research_image_file = Yii::$app->Upload->Updateimage($image_old, $model, 'research_output_apply', 'uploads/research/outputApply/', 'research_image_file'); 

            $model->update_by = $session['user_login'];
            $model->update_date = Yii::$app->formatter->asDatetime(time());

            if($model->save()){
                $session->setFlash('message', 'แก้ไขข้อมูลเรียบร้อย.');
                return $this->redirect(['output-apply-index', 'id' => $id]);
            }
        }

        return $this->render('output-apply/update', [
            'model' => $model,
            'value' => $value,
            'id' => $id,
        ]);
    }

    public function actionOutputApplyDelete($id, $research_image_id)
    {
        $model = ResearchImage::findOne($research_image_id);
        
        $session = new Session();
        $session->open();
        
        if(!empty($model)){
            @unlink(Yii::getAlias('@webroot/uploads/research/outputApply/').$model->research_image_file);
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

            return $this->redirect(['output-apply-index', 'id' => $id]);
        } 
    }
    // ---------- Output Apply ----------

}
