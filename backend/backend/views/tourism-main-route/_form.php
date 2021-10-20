<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

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

<div class="stepwizard col-md-offset-3" style="margin-top: 40px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลเส้นทาง</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>สื่อดิจิทัล</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>ข้อมูลติดต่อ</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'tourism_main_route_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tourism_main_route_name_en')->textInput(['maxlength' => true]) ?>


            <?php
            // echo $form->field($model, 'user_group_id')->widget(
            //     Select2::className(),
            //     [
            //         'data' => ArrayHelper::map(\app\models\UserGroup::find()->all(), 'user_group_id', 'user_group_name'),
            //         'language' => 'th',
            //         'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            //         'pluginOptions' => [
            //             'allowClear' => TRUE
            //         ]
            //     ]
            // )->label('กลุ่มผู้ใช้'); 
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Active
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if ($model->isNewRecord) {
                                $model->active = 'N';
                            }

                            echo $form->field($model, 'active')->radioList([
                                'Y' => 'Y',
                                'N' => 'N'
                            ])->label(false);
                            ?>
                        </div>

                    </div>
                </div>
            </div>

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

                <div class="panel-body">
                    <p>รายละเอียด</p>
                    <?=
                    $form->field($model, 'tourism_main_route_detail')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE)
                    ?>
                </div>

                <div class="panel-body">
                    <p>รายละเอียดภาษาอังกฤษ</p>
                    <?=
                    $form->field($model, 'tourism_main_route_detail_en')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label(FALSE)
                    ?>
                </div>
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

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่  
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพเส้นทางท่องเที่ยว (ขนาดภาพ 350*250)
                    </div>

                    <div class="panel-body">
                        <?=
                        $form->field($model, 'tourism_main_route_image')->widget(FileInput::className(), [
                            'options' => [
                                'accept' => 'image/*',
                                'pluginOptions' => [
                                    'showUpload' => FALSE,
                                    //'maxFileSize' => 3000
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
                        รูปภาพเส้นทางท่องเที่ยว (ขนาดภาพ 350*250)
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/tourism/' . $model->tourism_main_route_image, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'tourism_main_route_image')->widget(FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*',
                                    'pluginOptions' => [
                                        'showUpload' => false,
                                        //'maxFileSize' => 3000
                                    ]
                                ]
                            ])->label(FALSE);
                            ?>
                        </div>
                    </div>
                </div>
            <?php } //else  
            ?>

            <?= $form->field($model, 'tourism_main_route_vdo')->textInput()->label('วีดีโอ'); ?>

            <?= $form->field($model, 'tourism_main_route_link')->textInput()->label('ลิงค์'); ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'tourism_main_route_contact_name')->textInput()->label('ชื่อผู้ติดต่อ'); ?>

            <?= $form->field($model, 'tourism_main_route_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

            <?= $form->field($model, 'tourism_main_route_email')->textInput(['maxlength' => true])->label('email'); ?>

            <?= $form->field($model, 'tourism_main_route_facebook')->textInput(['maxlength' => true])->label('facebook'); ?>

            <?= $form->field($model, 'tourism_main_route_line')->textInput(['maxlength' => true])->label('line'); ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่  
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?=
                        $form->field($model, 'tourism_main_route_contact_image')->widget(FileInput::className(), [
                            'options' => [
                                'accept' => 'image/*',
                                'pluginOptions' => [
                                    'showUpload' => FALSE,
                                    //'maxFileSize' => 3000
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
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/tourism/' . $model->tourism_main_route_contact_image, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'tourism_main_route_contact_image')->widget(FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*',
                                    'pluginOptions' => [
                                        'showUpload' => false,
                                        //'maxFileSize' => 3000
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
                <a href="<?= Url::to(['tourism-main-route/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>