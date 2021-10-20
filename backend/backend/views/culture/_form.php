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
            <p>ข้อมูลทั่วไป</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>ตำแหน่ง</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>สื่อประชาสัมพันธ์</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php
            if ($session['user_login'] == 'admin') {
                echo $form->field($model, 'community_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
                        'language' => 'th',
                        'options' => [
                            'id' => 'ddl-community',
                            'placeholder' => 'เลือกชุมชน...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ]
                    ]
                )->label('ชุมชน');
            } else {
                $user = $session['user_login'];
                $data = Yii::$app->db->createCommand("select community_id from community where create_by = '$user' ")->queryAll();
                echo $form->field($model, 'community_id')->hiddenInput(['value' => $data[0]['community_id']])->label(false);
            }
            ?>

            <?php echo $form->field($model, 'culture_group_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\CultureGroup::find()->all(), 'culture_group_id', 'culture_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกกลุ่มวัฒนธรรม...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            ); ?>


            <?= $form->field($model, 'culture_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อวัฒนธรรม') ?>

            <?= $form->field($model, 'culture_name_en', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'culture_image_cover')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/culture/' . $model->culture_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'culture_image_cover')->widget(FileInput::className(), [
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
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step-2 -->
<div class="row setup-content" id="step-2">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'culture_place')->textInput(['maxlength' => true])->label('สถานที่') ?>

            <div class="panel panel-default">
                <h4>ที่อยู่</h4>
                <div class="row">
                    <div class="col-md-4">
                        <?=
                        $form->field($model, 'tambon_id')->widget(DepDrop::classname(), [
                            'data' => $tambon,
                            'pluginOptions' => [
                                'depends' => ['ddl-province', 'ddl-amphur'],
                                'placeholder' => 'เลือกตำบล...',
                                'url' => Url::to(['/culture/get-tambon'])
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
                                'url' => Url::to(['/culture/get-amphur']),
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
            </div>

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

            <?= $form->field($model, 'culture_detail')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('รายละเอียดภาษาไทย') ?>

            <?= $form->field($model, 'culture_detail_en')->widget(CKEditor::className(), [
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

<!-- step-4 -->
<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'culture_information')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('สื่อประชาสัมพันธ์') ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['culture/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>