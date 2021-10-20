<?php

use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\Session;
use kartik\depdrop\DepDrop;

$session = new Session();
$session->open();

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
            <p>ข้อมูลการนำไป<br>ใช้ประโยชน์</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>ตำแหน่ง</p>
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
            echo $form->field($model, 'researcher_output_apply_group_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\ResearchOutputApplyGroup::find()->all(), 'researcher_output_apply_group_id', 'researcher_output_apply_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]
            )->label('กลุ่มการนำไปใช้ประโยชน์');
            ?>

            <?php
            if ($session['user_login'] == 'admin') {
                echo $form->field($modelPathofOutputApply, 'researcher_tourism_product_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\ResearchTourismProduct::find()->all(), 'researcher_tourism_product_id', 'researcher_tourism_product_name'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]
                )->label('ผลิตภัณฑ์ท่องเที่ยว');
            } else {
                echo $form->field($modelPathofOutputApply, 'researcher_tourism_product_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\ResearchTourismProduct::find()
                            ->where(['create_by' => $session['user_login']])
                            ->all(), 'researcher_tourism_product_id', 'researcher_tourism_product_name'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]
                )->label('ผลิตภัณฑ์ท่องเที่ยว');
            }

            ?>

            <?php
            if ($session['user_login'] == 'admin') {
                echo $form->field($modelPathofOutputApply, 'researcher_innovation_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\ResearchInnovation::find()->all(), 'researcher_innovation_id', 'researcher_innovation_name'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]
                )->label('นวัตกรรม');
            } else {
                echo $form->field($modelPathofOutputApply, 'researcher_innovation_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\ResearchInnovation::find()
                            ->where(['create_by' => $session['user_login']])
                            ->all(), 'researcher_innovation_id', 'researcher_innovation_name'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]
                )->label('นวัตกรรม');
            }

            ?>

            <?= $form->field($model, 'researcher_output_apply_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อ') ?>

            <?= $form->field($model, 'researcher_output_apply_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>



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
                    $form->field($model, 'researcher_output_apply_detail')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'basic',
                    ])->label(FALSE)
                    ?>
                </div>

                <div class="panel-body">
                    <p>รายละเอียดภาษาอังกฤษ</p>
                    <?php
                    echo $form->field($model, 'researcher_output_apply_detail_en')->widget(CKEditor::className(), [
                        'options' => ['rows' => 3],
                        'preset' => 'basic',
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

<!-- step 3 -->
<div class="row setup-content" id="step-3">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'researcher_output_apply_place')->textInput(['maxlength' => true])->label('สถานที่') ?>

            <div class="row">
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'tambon_id')->widget(DepDrop::classname(), [
                        'data' => $tambon,
                        'pluginOptions' => [
                            'depends' => ['ddl-province', 'ddl-amphur'],
                            'placeholder' => 'เลือกตำบล...',
                            'url' => Url::to(['/research-output-apply/get-tambon'])
                        ]
                    ])->label('ตำบล')
                    ?>
                </div>
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'amphur_id')->widget(DepDrop::classname(), [
                        'options' => [
                            'id' => 'ddl-amphur',
                        ],
                        'data' => $amphur,
                        'pluginOptions' => [
                            'depends' => ['ddl-province'],
                            'placeholder' => 'เลือกอำเภอ...',
                            'url' => Url::to(['/research-output-apply/get-amphur'])
                        ],
                    ])->label('อำเภอ')
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    echo $form->field($model, 'province_id')->widget(
                        Select2::className(),
                        [
                            'data' => ArrayHelper::map(\app\models\Province::find()->all(), 'province_id', 'province_name'),
                            'language' => 'th',
                            'options' => [
                                'id' => 'ddl-province',
                                'placeholder' => 'เลือกจังหวัด...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]
                    )->label('จังหวัด');
                    ?>
                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="ddlAddress">ต่อไป</button>
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
                        <?= $form->field($model, 'researcher_output_apply_image_cover')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/research/outputApply/' . $model->researcher_output_apply_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'researcher_output_apply_image_cover')->widget(FileInput::className(), [
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

                    <?= $form->field($model, 'researcher_output_apply_vdo')->textInput()->label('ลิงค์วีดีโอ') ?>

                    <?= $form->field($model, 'researcher_output_apply_link')->textInput()->label('ลิงค์') ?>

                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['research-output-apply/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>