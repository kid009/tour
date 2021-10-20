<?php

use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();

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
            <p>ข้อมูลผลิตภัณฑ์ท่องเที่ยว</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>ราคาและโปรโมชั่น</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>สื่อดิจิทัล</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php
            //if ($session['user_login'] == 'admin') {
                echo $form->field($model, 'bussiness_product_tourism_group_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\BussinessProductTourismGroup::find()->all(), 'bussiness_product_tourism_group_id', 'bussiness_product_tourism_group_name'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]
                )->label('กลุ่มผลิตภัณฑ์ท่องเที่ยว');
            // } else {
            //     echo $form->field($model, 'bussiness_product_tourism_group_id')->widget(
            //         Select2::className(),
            //         [
            //             'data' => ArrayHelper::map(\app\models\BussinessProductTourismGroup::find()
            //                 ->where(['create_by' => $session['user_login']])
            //                 ->all(), 'bussiness_product_tourism_group_id', 'bussiness_product_tourism_group_name'),
            //             'language' => 'th',
            //             'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            //             'pluginOptions' => [
            //                 'allowClear' => true,
            //             ],
            //         ]
            //     )->label('กลุ่มผลิตภัณฑ์ท่องเที่ยว');
            // }
            ?>

            <?= $form->field($model, 'bussiness_product_tourism_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อ') ?>

            <?= $form->field($model, 'bussiness_product_tourism_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>

            <?= $form->field($model, 'bussiness_product_tourism_story')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('เรื่องราว') ?>

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

            <?= $form->field($model, 'bussiness_product_tourism_detail')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('รายละเอียดภาษาไทย') ?>

            <?= $form->field($model, 'bussiness_product_tourism_detail_en')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('รายละเอียดภาษาอังกฤษ') ?>

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

            <?= $form->field($model, 'bussiness_product_tourism_price')->textInput(['type' => 'number'])->label('ราคา (บาท) *ใส่เฉพาะตัวเลข') ?>

            <?= $form->field($model, 'bussiness_product_tourism_promotion')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('โปรโมชั่น') ?>           

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step 4 -->
<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'bussiness_product_tourism_image_cover')->widget(FileInput::className(), [
                            'options' => [
                                'accept' => 'image/*',
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'maxFileSize' => 3000,
                                ],
                            ],
                        ])->label(false); ?>
                    </div>
                </div>
            <?php } //if
            else { //แก้ไขข้อมูล
            ?>
                <!-- แก้ไขข้อมูล -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/bussiness/product_tourism/' . $model->bussiness_product_tourism_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'bussiness_product_tourism_image_cover')->widget(FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*',
                                    'pluginOptions' => [
                                        'showUpload' => false,
                                        'maxFileSize' => 3000,
                                    ],
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
            <?php } //else
            ?>

            <div class="panel panel-default">
                <div class="panel-body">

                    <?= $form->field($model, 'bussiness_product_tourism_vdo')->textInput()->label('ลิงค์วีดีโอ') ?>

                    <?= $form->field($model, 'bussiness_product_tourism_link')->textInput()->label('ลิงค์') ?>

                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['bussiness-product-tourism/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>