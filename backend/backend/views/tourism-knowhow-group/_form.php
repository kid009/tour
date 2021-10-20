<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//เรียกใช้ไฟล์ css
$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);
//เรียกใช้ไฟล์ js
$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

?>

<div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลกลุ่มองค์ความรู้การท่องเที่ยว</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin();?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?=$form->field($model, 'tourism_knowhow_group_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อ')?>

            <?=$form->field($model, 'tourism_knowhow_group_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ')?>

            <div class="pull-right">

                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>

            </div>

        </div>
    </div>
</div>

<!-- step-2 -->
<div class="row setup-content" id="step-2">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-body">
                    <p>รายละเอียดภาษาไทย</p>
                    <?=
                        $form->field($model, 'tourism_knowhow_group_name_detail')->widget(CKEditor::className(), [
                        'options' => ['row' => 6],
                        'preset' => 'basic',
                        ])->label(false)
                    ?>
                </div>

                <div class="panel-body">
                    <p>รายละเอียดภาษาอังกฤษ</p>
                    <?php
                        echo $form->field($model, 'tourism_knowhow_group_name_detail_en')->widget(CKEditor::className(), [
                        'options' => ['row' => 6],
                        'preset' => 'basic',
                        ])->label(false)
                    ?>
                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?=Html::submitButton('บันทึก', ['class' => 'btn btn-success'])?>
                <a href="<?=Url::to(['tourism-knowhow-group/index']);?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end();?>