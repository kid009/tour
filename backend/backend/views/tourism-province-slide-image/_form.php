<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
?>

<div class="tourism-province-slide-image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่  
    ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                รูปภาพ (ขนาดภาพ 1920*1280)
            </div>

            <div class="panel-body">
                <?php
                echo $form->field($model, 'tourism_province_silde_image_name', ['enableAjaxValidation' => true])->widget(FileInput::className(), [
                    'options' => [
                        'accept' => 'image/*',
                        'pluginOptions' => [
                            //'showUpload' => true,
                            'maxFileSize' => 3000
                        ]
                    ]
                ])->label(FALSE);
                ?>
            </div>
        </div>
    <?php
    } //if
    else { //แก้ไขข้อมูล       
    ?>
        <!-- แก้ไขข้อมูล -->
        <div class="panel panel-default">
            <div class="panel-heading">
                รูปภาพ (ขนาดภาพ 1920*1280)
            </div>

            <div class="panel-body">
                <div class="col-md-3">
                    <?= Html::img('@web/uploads/frontend/slide_image/' . $model->tourism_province_silde_image_name, ['style' => 'height:100px;weidth:100px;']) ?>
                    <br><br>
                </div>
                <div class="col-md-9">
                    <?php
                    echo $form->field($model, 'tourism_province_silde_image_name', ['enableAjaxValidation' => true])->widget(FileInput::className(), [
                        'options' => [
                            'accept' => 'image/*',
                            'pluginOptions' => [
                                //'showUpload' => false,
                                'maxFileSize' => 3000
                            ]
                        ]
                    ])->label(FALSE);
                    ?>
                </div>
            </div>
        </div>
    <?php } //else  
    ?>

    <?= $form->field($model, 'tourism_province_silde_image_header')->textInput(['maxlength' => true])->label('หัวเรื่อง'); ?>

    <?= $form->field($model, 'tourism_province_silde_image_text')->textInput(['maxlength' => true])->label('ข้อความ'); ?>

    <?= $form->field($model, 'tourism_province_slide_order', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ลำดับ'); ?>

    <div class="panel-body">
        <h4>Active</h4>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    $model->active = 'N';
                    echo $form->field($model, 'active')->radioList([
                        'Y' => 'Y',
                        'N' => 'N'
                    ])->label(FALSE);
                } else {
                    echo $form->field($model, 'active')->radioList([
                        'Y' => 'Y',
                        'N' => 'N'
                    ])->label(false);
                }
                ?>
            </div>

        </div>
    </div>

    <!--<div class="panel panel-default">
        <div class="panel-heading">
            Type
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    /*if($model->isNewRecord){
                            $model->type_slide_image = 'Header';
                            echo $form->field($model, 'type_slide_image')->radioList([
                                'Header' => 'Header', 
                                'Map' => 'Map'
                            ])->label(FALSE);
                        }
                        else {
                            echo $form->field($model, 'type_slide_image')->radioList([
                                'Header' => 'Header', 
                                'Map' => 'Map'
                            ])->label(false); 
                        }*/
                    ?>
                </div>
                
            </div>
        </div>
    </div>-->

    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['tourism-province-slide-image/index']); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>