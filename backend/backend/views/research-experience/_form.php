<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\web\Session;

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
            <p>ข้อมูลประสบการณ์</p>
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
            //if($session['user_login'] == 'admin'){
                echo $form->field($model, 'researcher_experience_group_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\ResearchExperienceGroup::find()
                            ->all(), 'researcher_experience_group_id', 'researcher_experience_group_name'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เลือกกลุ่มประสบการณ์...'],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ]
                    ]
                )->label('กลุ่มประสบการณ์'); 
            // }
            // else{
            //     echo $form->field($model, 'researcher_experience_group_id')->widget(
            //         Select2::className(),
            //         [
            //             'data' => ArrayHelper::map(\app\models\ResearchExperienceGroup::find()
            //                 ->where(['create_by' => $session['user_login']])
            //                 ->all(), 'researcher_experience_group_id', 'researcher_experience_group_name'),
            //             'language' => 'th',
            //             'options' => ['placeholder' => 'เลือกกลุ่มประสบการณ์...'],
            //             'pluginOptions' => [
            //                 'allowClear' => TRUE
            //             ]
            //         ]
            //     )->label('กลุ่มประสบการณ์'); 
            // }
            ?>

            <?= $form->field($model, 'researcher_experience_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อประสบการณ์') ?>

            <?= $form->field($model, 'researcher_experience_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>

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
                    <?= $form->field($model, 'researcher_experience_detail')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE) ?>
                </div>

                <div class="panel-body">
                    <p>รายละเอียดภาษาอังกฤษ</p>
                    <?= $form->field($model, 'researcher_experience_detail_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE) ?>
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
                        <?= $form->field($model, 'researcher_experience_image_cover')->widget(FileInput::className(), [
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
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/research/experience/'  . $model->researcher_experience_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'researcher_experience_image_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'researcher_experience_vdo')->textInput(['maxlength' => true])->label('ลิงค์วีดีโอ') ?>

            <?= $form->field($model, 'researcher_experience_link')->textInput(['maxlength' => true])->label('ลิงค์') ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['research-experience/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>