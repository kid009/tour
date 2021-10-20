<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
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
            <p>ข้อมูล<br>องค์ความรู้</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>นวัตกรรม</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>เทคโนโลยี</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-5" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">5</a>
            <p>สื่อดิจิทัล</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-6" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">6</a>
            <p>ข้อมูลติดต่อ</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

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

            <?php echo $form->field($model, 'knowhow_group_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\KnowhowGroup::find()->all(), 'knowhow_group_id', 'knowhow_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกชุมชน...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            ); ?>

            <?= $form->field($model, 'knowhow_name')->textInput(['required' => true]) ?>

            <?= $form->field($model, 'knowhow_name_en')->textInput(['maxlength' => true]) ?>

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
                    <?= $form->field($model, 'knowhow_detail')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('รายละเอียด') ?>

                    <?= $form->field($model, 'knowhow_detail_en')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('รายละเอียดภาษาอังกฤษ') ?>
                </div>

                <div class="pull-right">
                    <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                    <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
                </div>
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

                    <?= $form->field($model, 'knowhow_innovation_name')->textInput()->label('ชื่อนวัตกรรม'); ?>

                    <?= $form->field($model, 'knowhow_innovation_resource')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('องค์ประกอบนวัตกรรม') ?>

                    <?= $form->field($model, 'knowhow_innovation_process')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('รายละเอียดนวัตกรรม') ?>

                    <?= $form->field($model, 'knowhow_innovation_result')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('ผลลัพท์') ?>

                    <?= $form->field($model, 'knowhow_innovation_apply')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('การนำไปใช้ประโยชน์') ?>

                    <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                รูปภาพนวัตกรรม
                            </div>

                            <div class="panel-body">
                                <?= $form->field($model, 'knowhow_innovation_image')->widget(FileInput::className(), [
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
                                รูปภาพนวัตกรรม
                            </div>

                            <div class="panel-body">
                                <div class="col-md-3">
                                    <?= Html::img('@web/uploads/community/' . $model->community_id . '/knowhow/' . $model->knowhow_innovation_image, ['style' => 'height:100px;weidth:100px;']) ?>
                                    <br><br>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    echo $form->field($model, 'knowhow_innovation_image')->widget(FileInput::className(), [
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

                    <?= $form->field($model, 'knowhow_innovation_vdo')->textInput()->label('วีดีโอนวัตกรรม'); ?>

                    <?= $form->field($model, 'knowhow_innovation_link')->textInput()->label('ลิงค์นวัตกรรม'); ?>

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

            <div class="panel panel-default">

                <div class="panel-body">

                    <?= $form->field($model, 'knowhow_technology_name')->textInput()->label('ชื่อเทคโนโลยี'); ?>

                    <?= $form->field($model, 'knowhow_technology_resource')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('องค์ประกอบเทคโนโลยี') ?>

                    <?= $form->field($model, 'knowhow_technology_process')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('รายละเอียดเทคโนโลยี') ?>

                    <?= $form->field($model, 'knowhow_technology_result')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('ผลลัพท์') ?>

                    <?= $form->field($model, 'knowhow_technology_apply')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'basic',
                    ])->label('การนำไปใช้ประโยชน์') ?>

                    <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                รูปภาพเทคโนโลยี
                            </div>

                            <div class="panel-body">
                                <?= $form->field($model, 'knowhow_technology_image')->widget(FileInput::className(), [
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
                                รูปภาพเทคโนโลยี
                            </div>

                            <div class="panel-body">
                                <div class="col-md-3">
                                    <?= Html::img('@web/uploads/community/' . $model->community_id . '/knowhow/' . $model->knowhow_technology_image, ['style' => 'height:100px;weidth:100px;']) ?>
                                    <br><br>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    echo $form->field($model, 'knowhow_technology_image')->widget(FileInput::className(), [
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

                    <?= $form->field($model, 'knowhow_technology_vdo')->textInput()->label('วีดีโอเทคโนโลยี'); ?>

                    <?= $form->field($model, 'knowhow_technology_link')->textInput()->label('ลิงค์เทคโนโลยี'); ?>

                </div>

                <div class="pull-right">
                    <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                    <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- step-5 -->
<div class="row setup-content" id="step-5">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'knowhow_image_cover')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/knowhow/' . $model->knowhow_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'knowhow_image_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'knowhow_vdo')->textInput()->label('วีดีโอ'); ?>

            <?= $form->field($model, 'knowhow_link')->textInput()->label('ลิงค์'); ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>
        </div>
    </div>
</div>

<!-- Step6 -->
<div class="row setup-content" id="step-6">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'knowhow_contact_person')->textInput()->label('ชื่อผู้ติดต่อ'); ?>

            <?= $form->field($model, 'knowhow_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

            <?= $form->field($model, 'knowhow_email')->textInput(['maxlength' => true])->label('email'); ?>

            <?= $form->field($model, 'knowhow_facebook')->textInput(['maxlength' => true])->label('facebook'); ?>

            <?= $form->field($model, 'knowhow_line')->textInput(['maxlength' => true])->label('line'); ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'knowhow_image_contact')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/knowhow/' . $model->knowhow_image_contact, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'knowhow_image_contact')->widget(FileInput::className(), [
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
                <a href="<?= Url::to(['special-group/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>