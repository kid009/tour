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
            <p>ข้อมูลองค์ความรู้<br>การท่องเที่ยว</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
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
            echo $form->field($model, 'tourism_knowhow_group_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\TourismKnowhowGroup::find()->all(), 'tourism_knowhow_group_id', 'tourism_knowhow_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]
            )->label('กลุ่มองค์ความรู้การท่องเที่ยว');
            ?>


            <?= $form->field($model, 'tourism_knowhow_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อองค์ความรู้การท่องเที่ยว') ?>

            <?= $form->field($model, 'tourism_knowhow_name_en', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>

            <?= $form->field($model, 'tourism_knowhow_place')->textInput(['maxlength' => true])->label('สถานที่') ?>

            <?php
            if ($model->isNewRecord) {
                $model->is_active = 'N';
                echo $form->field($model, 'is_active')->radioList([
                    'Y' => 'Y',
                    'N' => 'N',
                ])->label('Active');
            } else {
                echo $form->field($model, 'is_active')->radioList([
                    'Y' => 'Y',
                    'N' => 'N',
                ])->label('Active');
            }
            ?>

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
                    <?= $form->field($model, 'tourism_knowhow_detail')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'standard',
                    ])->label(false) ?>
                </div>

                <div class="panel-body">
                    <p>รายละเอียดภาษาอังกฤษ</p>
                    <?= $form->field($model, 'tourism_knowhow_detail_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'standard',
                    ])->label(false) ?>
                </div>
            </div>



            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step 3 -->
<div class="row setup-content" id="step-3">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'tourism_knowhow_image_cover')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/tourism/knowhow/' . $model->tourism_knowhow_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'tourism_knowhow_image_cover')->widget(FileInput::className(), [
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

                    <?= $form->field($model, 'tourism_knowhow_vdo')->textInput()->label('ลิงค์วีดีโอ') ?>

                    <?= $form->field($model, 'tourism_knowhow_link')->textInput()->label('ลิงค์') ?>

                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['tourism-knowhow/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>