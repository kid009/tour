<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

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

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>ผลลัพธ์/<br>การนำไปใช้ประโยชน์</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>ข้อมูลติดต่อ</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php echo $form->field($model, 'product_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\Product::find()->all(), 'product_id', 'product_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกสินค้า...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            )->label('สินค้า'); ?>

            <?= $form->field($model, 'best_study_name')->textInput(['maxlength' => true])->label('Best Study Name') ?>

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

            <?= $form->field($model, 'best_study_vdo')->textInput(['maxlength' => true])->label('VDO')->label('ลิงค์วีดีโอ') ?>

            <div class="panel-body">
                <p>รายละเอียด</p>
                <?= $form->field($model, 'best_study_detail')->widget(CKEditor::className(), [
                    'options' => ['row' => 3],
                    'preset' => 'standard',
                ])->label(FALSE) ?>
            </div>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพหน้าปก
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'best_study_image_cover')->widget(FileInput::className(), [
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
            <?php } //if
            else { //แก้ไขข้อมูล       
            ?>
                <!-- แก้ไขข้อมูล -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพหน้าปก
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?php echo Html::img('@web/uploads/beststudy/' . $model->best_study_image_cover, ['style' => 'height:100px;weidth:100px;'])
                            ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'best_study_image_cover')->widget(FileInput::className(), [
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

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step-3 -->
<div class="row setup-content" id="step-3">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-body">
                    <p>ผลลัพธ์</p>
                    <?= $form->field($model, 'best_study_result')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE) ?>
                </div>

                <div class="panel-body">
                    <p>การนำไปใช้ประโยชน์</p>
                    <?= $form->field($model, 'best_study_apply')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE) ?>
                </div>

                <div class="pull-right">
                    <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                    <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- step-4 -->
<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'best_study_name_contact')->textInput(['maxlength' => true])->label('ชื่อผู้ติดต่อ') ?>

            <?= $form->field($model, 'best_study_telephone')->textInput(['maxlength' => true])->label('เบอร์ผู้ติดต่อ') ?>

            <?= $form->field($model, 'best_study_email')->textInput(['maxlength' => true])->label('อีเมล') ?>

            <?= $form->field($model, 'best_study_line')->textInput(['maxlength' => true])->label('Line') ?>

            <?= $form->field($model, 'best_study_facebook')->textInput(['maxlength' => true])->label('Facebook') ?>

            <?= $form->field($model, 'best_study_instagram')->textInput(['maxlength' => true])->label('Instagram') ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'best_study_image_contact')->widget(FileInput::className(), [
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
            <?php } //if
            else { //แก้ไขข้อมูล       
            ?>
                <!-- แก้ไขข้อมูล -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?php echo Html::img('@web/uploads/beststudy/' . $model->best_study_image_contact, ['style' => 'height:100px;weidth:100px;'])
                            ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'best_study_image_contact')->widget(FileInput::className(), [
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

            



            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>

                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['knowhow/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>