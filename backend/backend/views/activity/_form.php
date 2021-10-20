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
$user = $session['user_login'];
$data = Yii::$app->db->createCommand("select community_id from community where create_by = '$user' ")->queryAll();
$community_id = $data[0]['community_id'];
?>

<div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลกิจกรรม</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>ข้อมูลกิจกรรม</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>สื่อดิจิทัล</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-5" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">5</a>
            <p>ข้อมูลติดต่อ</p>
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
                echo $form->field($model, 'community_id')->hiddenInput(['value' => $data[0]['community_id']])->label(false);
            }
            ?>

            <?php
            echo $form->field($model, 'activity_group_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\ActivityGroup::find()->all(), 'activity_group_id', 'activity_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกกลุ่มกิจกรรม...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            );
            ?>

            <?php
            echo $form->field($model, 'knowhow_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\Knowhow::find()
                        ->where(['community_id' => $community_id])
                        ->all(), 'knowhow_id', 'knowhow_name'),
                    'language' => 'th',
                    'options' => [
                        'placeholder' => 'เลือกความรู้...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            )->label('กลุ่มความรู้ชุมชน');
            ?>

            <?= $form->field($model, 'activity_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'activity_name_en')->textInput(['maxlength' => true]) ?>

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

                    <?=
                    $form->field($model, 'activity_detail')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'full',
                    ])->label('รายละเอียด')
                    ?>

                    <?=
                    $form->field($model, 'activity_detail_en')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'full',
                    ])->label('รายละเอียดภาษาอังกฤษ')
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

<!-- step-3 -->
<div class="row setup-content" id="step-3">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <?= $form->field($model, 'activity_price')->textInput(['type' => 'number']) ?>

                    <?= $form->field($model, 'activity_participant_min')->textInput(['type' => 'number']) ?>

                    <?= $form->field($model, 'activity_participant_max')->textInput(['type' => 'number']) ?>

                    <?= $form->field($model, 'activity_period')->textInput() ?>

                    <?= $form->field($model, 'activity_participant_age')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'activity_duration')->textInput(['type' => 'number']) ?>

                    <?=
                    $form->field($model, 'activity_duration_text')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'full',
                    ])->label('รายละเอียดเวลาทำกิจกรรม')
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

<!-- step-4 -->
<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่   
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพกิจกรรม
                    </div>

                    <div class="panel-body">
                        <?php
                        echo $form->field($model, 'activity_image_cover')->widget(FileInput::className(), [
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
                    <div class="panel-heading">
                        รูปภาพกิจกรรม
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/activity/' . $model->activity_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'activity_image_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'activity_link_vdo')->textInput()->label('วิดีโอ') ?>

            <?= $form->field($model, 'activity_link')->textInput()->label('ลิงค์') ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step-5 -->
<div class="row setup-content" id="step-5">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'activity_contact_name')->textInput()->label('ชื่อผู้ติดต่อ'); ?>

            <?= $form->field($model, 'activity_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

            <?= $form->field($model, 'activity_email')->textInput(['maxlength' => true])->label('email'); ?>

            <?= $form->field($model, 'activity_facebook')->textInput(['maxlength' => true])->label('facebook'); ?>

            <?= $form->field($model, 'activity_line')->textInput(['maxlength' => true])->label('line'); ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่   
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?php
                        echo $form->field($model, 'activity_contact_image')->widget(FileInput::className(), [
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
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/activity/' . $model->activity_contact_image, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'activity_contact_image')->widget(FileInput::className(), [
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
                <a href="<?= Url::to(['activity/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>