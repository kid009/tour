<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;

$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);

$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลทั่วไป</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<!-- Step 1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php
            echo $form->field($model, 'province_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\app\models\Province::find()->all(), 'province_id', 'province_name'),
                'language' => 'th',
                'options' => [
                    'placeholder' => 'เลือกจังหวัด...'
                ],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ])->label('จังหวัด');
            ?>

            <?= $form->field($model, 'tourism_province_name')->textInput(['maxlength' => true])->label('ชื่อจังหวัด') ?>

            <?= $form->field($model, 'tourism_province_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>

            <?= $form->field($model, 'tourism_province_order', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ลำดับ') ?>

            <div class="pull-right">
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- Step2 -->
<div class="row setup-content" id="step-2">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body">

                    <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                    ?>
                        <div class="panel panel-default">
                            <p>รูปภาพ (ขนาดภาพ 1920*1280)</p>

                            <div class="panel-body">
                                <?php
                                echo $form->field($model, 'tourism_province_image_1')->widget(FileInput::className(), [
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
                    <?php
                    } //if
                    else { //แก้ไขข้อมูล       
                    ?>
                        <!-- แก้ไขข้อมูล -->
                        <div class="panel panel-default">
                            <p>รูปภาพ (ขนาดภาพ 1920*1280)</p>

                            <div class="panel-body">
                                <div class="col-md-3">
                                    <?php echo Html::img('@web/uploads/frontend/' . $model->tourism_province_image_1, ['style' => 'height:100px;weidth:100px;']) ?>
                                    <br><br>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    echo $form->field($model, 'tourism_province_image_1')->widget(FileInput::className(), [
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
                    <?php } //else   
                    ?>
                </div>

                <div class="panel-body">
                    <p>ประวัติความเป็นมาของจังหวัด/รายละเอียดจังหวัด</p>
                    <?= $form->field($model, 'tourism_province_detail')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE) ?>
                </div>

                <div class="panel-body">
                    <p>รายละเอียดภาษาอังกฤษ</p>
                    <?= $form->field($model, 'tourism_province_detail_en')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE) ?>
                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>

                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['tourism-province/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>