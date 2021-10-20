<?php

use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;
use kartik\depdrop\DepDrop;

if ($tourismMainRouteId != "") {
    $num = Yii::$app->db->createCommand("
    select max(tourism_sub_route_order)
    from tourism_sub_route
    where tourism_main_route_id = $tourismMainRouteId      
    ")->queryOne();
}

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
            <p>เส้นทางย่อย</p>
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
<!-- step1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">
            <?php
            if ($tourismMainRouteId != "") {
                echo $form->field($model, 'tourism_main_route_id')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(\app\models\TourismMainRoute::find()->where(['tourism_main_route_id' => $tourismMainRouteId])->all(), 'tourism_main_route_id', 'tourism_main_route_name'),
                    'language' => 'th',
                ]);
            } else if ($tourismMainRouteId == "") {
                echo $form->field($model, 'tourism_main_route_id')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(\app\models\TourismMainRoute::find()->all(), 'tourism_main_route_id', 'tourism_main_route_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกเส้นทางท่องเที่ยวหลัก...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]);
            }
            ?>

            <?= $form->field($model, 'tourism_sub_route_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tourism_sub_route_name_initial')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tourism_sub_route_name_en')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tourism_sub_route_name_initial_eng')->textInput() ?>

            <?php
            if ($model->isNewRecord) {
                if ($tourismMainRouteId != null) {
                    foreach ($num as $nums) {
                        echo $form->field($model, 'tourism_sub_route_order')->textInput(['value' => $nums + 1, 'type' => 'number']);
                    }
                } else {
                    echo $form->field($model, 'tourism_sub_route_order')->textInput(['type' => 'number']);
                }
            } else {
                echo $form->field($model, 'tourism_sub_route_order')->textInput(['type' => 'number']);
            }
            ?>
            <div class="pull-right">
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>
        </div>
    </div>
</div>

<!-- step2 -->
<div class="row setup-content" id="step-2">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body">

                    <?=
                    $form->field($model, 'tourism_sub_route_detail')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
                    ])->label('รายละเอียด')
                    ?>

                    <?=
                    $form->field($model, 'tourism_sub_route_detail_en')->widget(CKEditor::className(), [
                        'options' => ['row' => 3],
                        'preset' => 'standard',
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

<!-- step3 -->
<div class="row setup-content" id="step-3">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?=
                        $form->field($model, 'tourism_sub_route_image_cover')->widget(FileInput::className(), [
                            'options' => [
                                'accept' => 'image/*',
                                'pluginOptions' => [
                                    'showUpload' => FALSE,
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
                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/tourism/' . $model->tourism_sub_route_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'tourism_sub_route_image_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'tourism_sub_route_vdo')->textInput()->label('วีดีโอ'); ?>

            <?= $form->field($model, 'tourism_sub_route_link')->textInput()->label('ลิงค์'); ?>

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

            <?= $form->field($model, 'tourism_sub_route_contact_name')->textInput()->label('ชื่อผู้ติดต่อ'); ?>

            <?= $form->field($model, 'tourism_sub_route_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

            <?= $form->field($model, 'tourism_sub_route_email')->textInput(['maxlength' => true])->label('email'); ?>

            <?= $form->field($model, 'tourism_sub_route_facebook')->textInput(['maxlength' => true])->label('facebook'); ?>

            <?= $form->field($model, 'tourism_sub_route_line')->textInput(['maxlength' => true])->label('line'); ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?=
                        $form->field($model, 'tourism_sub_route_contact_image')->widget(FileInput::className(), [
                            'options' => [
                                'accept' => 'image/*',
                                'pluginOptions' => [
                                    'showUpload' => FALSE,
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
                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/tourism/' . $model->tourism_sub_route_contact_image, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'tourism_sub_route_contact_image')->widget(FileInput::className(), [
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
                <a href="<?= Url::to(['tourism-sub-route/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>