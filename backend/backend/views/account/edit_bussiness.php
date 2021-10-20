<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\Session;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;

$session = new Session();
$session->open();
//var_dump($modelUserResearcher);
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
<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">

        <div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
            <div class="stepwizard-row setup-panel">

                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
                    <p>ข้อมูลส่วนตัวภาคธุรกิจ</p>
                </div>

                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
                    <p>ข้อมูลติดต่อสื่อสาร</p>
                </div>

                <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
                    <p>รูปภาพ</p>
                </div>

            </div>
        </div>

        <?php $form = ActiveForm::begin(); ?>

        <div class="row setup-content" id="step-1">
            <div class="col-xs-8 col-md-offset-2">
                <div class="col-md-12">

                    <?php echo $form->field($modelUserBussiness, 'user_bussiness_name')->textInput()->label('ชื่อ-นามสกุล') ?>

                    <div class="pull-right">
                        <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row setup-content" id="step-2">
            <div class="col-xs-8 col-md-offset-2">
                <div class="col-md-12">

                    <div class="panel panel-default">

                        <?php echo $form->field($modelUserBussiness, 'user_bussiness_address')->textInput()->label('ที่อยู่') ?>

                        <div class="row">
                            <div class="col-md-4">
                                <?=
                                $form->field($modelUserBussiness, 'tambon_id')->widget(DepDrop::classname(), [
                                    'data' => $tambon,
                                    'pluginOptions' => [
                                        'depends' => ['ddl-province', 'ddl-amphur'],
                                        'placeholder' => 'เลือกตำบล...',
                                        'url' => Url::to(['/account/get-tambon'])
                                    ]
                                ])->label('ตำบล')
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($modelUserBussiness, 'amphur_id')->widget(DepDrop::classname(), [
                                    'options' => [
                                        'id' => 'ddl-amphur',
                                    ],
                                    'data' => $amphur,
                                    'pluginOptions' => [
                                        'depends' => ['ddl-province'],
                                        'placeholder' => 'เลือกอำเภอ...',
                                        'url' => Url::to(['/account/get-amphur'])
                                    ],
                                ])->label('อำเภอ')
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($modelUserBussiness, 'province_id')->dropDownList(
                                    ArrayHelper::map(
                                        \app\models\Province::find()->all(),
                                        'province_id',
                                        'province_name'
                                    ),
                                    [
                                        'id' => 'ddl-province',
                                        'prompt' => 'เลือกจังหวัด'
                                    ]
                                )->label('จังหวัด');
                                ?>
                            </div>
                        </div>

                        <?php echo $form->field($modelUserBussiness, 'user_bussiness_telephone')->textInput()->label('เบอร์โทรศัพท์') ?>

                        <?php echo $form->field($modelUserBussiness, 'user_bussiness_email')->textInput(['maxlength' => true])->label('อีเมล') ?>

                        <?php echo $form->field($modelUserBussiness, 'user_bussiness_line')->textInput()->label('Line') ?>

                        <?php echo $form->field($modelUserBussiness, 'user_bussiness_facebook')->textInput(['maxlength' => true])->label('Facebook') ?>

                        <?php echo $form->field($modelUserBussiness, 'user_bussiness_instragram')->textInput()->label('Instragram') ?>

                    </div>

                    <div class="pull-right">
                        <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                        <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row setup-content" id="step-3">
            <div class="col-xs-8 col-md-offset-2">
                <div class="col-md-12">

                    <div class="panel panel-default">

                        <?php if ($modelUserBussiness->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                        ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    รูปภาพหน้าปก
                                </div>

                                <div class="panel-body">
                                    <?= $form->field($modelUserBussiness, 'user_bussiness_image')->widget(FileInput::className(), [
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
                                        <?php echo Html::img('@web/uploads/account/' . $modelUserBussiness->user_bussiness_image, ['style' => 'height:100px;weidth:100px;'])
                                        ?>
                                        <br><br>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        echo $form->field($modelUserBussiness, 'user_bussiness_image')->widget(FileInput::className(), [
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

                    <div class="pull-right">
                        <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                        <a href="<?= Url::to(['account/index']); ?>" class="btn btn-danger">
                            ยกเลิก
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        
    </div>
</div>