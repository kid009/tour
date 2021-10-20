<?php
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="culture-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'topic_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Topic::find()->all(), 'topic_id', 'topic_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกประเภทบทความ...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('ประเภทบทความ'); ?>

    <?= $form->field($model, 'post_title', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('หัวข้อ') ?>
    
    <?= $form->field($model, 'post_slug')->textInput(['maxlength' => true])->label('Slug') ?>

    <?php if($model->isNewRecord){ //เพิ่มข้อมูลใหม่ ?>
    <div class="panel panel-default">
         <div class="panel-heading">
            รูปภาพ
        </div>
        
        <div class="panel-body">
        <?= $form->field($model, 'post_image')->widget(FileInput::className(), [
            'options' => [
                'accept' => 'image/*',
                'pluginOptions' => [
                    'showUpload' => FALSE,
                    'maxFileSize' => 3000
                ]
            ]
        ])->label(FALSE); ?>
        </div>
    </div> 
    <?php }//if
        else{ //แก้ไขข้อมูล       
    ?>
    <!-- แก้ไขข้อมูล -->   
    <div class="panel panel-default">
        <div class="panel-heading">
            รูปภาพ
        </div>
               
        <div class="panel-body">   
            <div class="col-md-3">
                <?php echo Html::img('@web/uploads/post/'.$model->post_image, ['style' => 'height:100px;weidth:100px;']) ?>
                <br><br>
            </div>
            <div class="col-md-9">
                <?php 
                    echo $form->field($model, 'post_image')->widget(FileInput::className(), [
                            'options' => [
                                'accept' => 'image/*',
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'maxFileSize' => 3000
                                ]
                            ]
                    ])->label(FALSE);              
                ?>
            </div>                       
        </div>        
    </div>
    <?php }//else ?>

    <div class="panel panel-default">
        <div class="panel-body">  
            <p>รายละเอียด</p>
            <?= $form->field($model, 'post_detail')->widget(CKEditor::className(), [
                'options' => ['row' => 3],
                'preset' => 'standard',
            ])->label(FALSE) ?>     
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Active
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if($model->isNewRecord){
                            $model->is_active = 'N';
                            echo $form->field($model, 'is_active')->radioList([
                                'Y' => 'Y', 
                                'N' => 'N'
                            ])->label(FALSE);
                        }
                        else {
                            echo $form->field($model, 'is_active')->radioList([
                                'Y' => 'Y',
                                'N' => 'N'
                            ])->label(false); 
                        }
                    ?>
                </div>
                
            </div>
        </div>
    </div>

    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['post/index']); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
