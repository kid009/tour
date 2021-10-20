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
            <p>ข้อมูลทั่วไป</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>ราคา/โปรโมชั่น</p>
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

            <?php
            if ($session['user_login'] == 'admin') {
                echo $form->field($model, 'special_group_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\SpecialGroup::find()
                            //->where(['create_by' => $session['user_login']])
                            ->all(), 'special_group_id', 'special_group_name'),
                        'language' => 'th',
                        'options' => [
                            'placeholder' => 'เลือกกลุ่มอาชีพ...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ]
                    ]
                )->label('กลุ่มอาชีพ');
            } else {
                echo $form->field($model, 'special_group_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\SpecialGroup::find()
                            ->where(['create_by' => $session['user_login']])
                            ->all(), 'special_group_id', 'special_group_name'),
                        'language' => 'th',
                        'options' => [
                            'placeholder' => 'เลือกกลุ่มอาชีพ...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ]
                    ]
                )->label('กลุ่มอาชีพ');
            }
            ?>

            <?php
            echo $form->field($model, 'product_group_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(\app\models\ProductGroup::find()->all(), 'product_group_id', 'product_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            )->label('กลุ่มสินค้า');
            ?>

            <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'product_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ'); ?>

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

            <?=
            $form->field($model, 'product_detail')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('รายละเอียด')
            ?>

            <?=
            $form->field($model, 'product_detail_en')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('รายละเอียดภาษาอังกฤษ')
            ?>

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

            <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'product_price')->textInput(['type' => 'number']) ?>

            <?php //echo $form->field($model, 'product_stock_total')->textInput() 
            ?>

            <?= $form->field($model, 'product_unit')->textInput(['maxlength' => true]) ?>

            <?=
            $form->field($model, 'product_promotion')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('โปรโมชั่น')
            ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step4 -->
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
                        <?=
                        $form->field($model, 'product_image_cover')->widget(FileInput::className(), [
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
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/product/' . $model->product_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'product_image_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'product_vdo')->textInput(['maxlength' => true])->label('วีดีโอ') ?>

            <?= $form->field($model, 'product_link')->textInput(['maxlength' => true])->label('ลิงค์') ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step5 -->
<div class="row setup-content" id="step-5">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php

            $dataPeople = Yii::$app->db->createCommand("
            select people_name, concat(people_name, ' (', special_group_name, ')') as name
            from special_group_people
            inner join special_group on special_group_people.special_group_id =special_group .special_group_id
            inner join people on special_group_people.people_id = people.people_id
            where special_group.community_id = $community_id
            ")->queryAll();
            $dataArray = ArrayHelper::map($dataPeople, 'people_name', 'name');
            echo $form->field($model, 'product_contact_name')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map($dataPeople, 'people_name', 'name'),
                    'language' => 'th',
                    'options' => [
                        //'id' => 'ddl-community',
                        'placeholder' => 'เลือกผู้ติดต่อ...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            )->label('ชื่อผู้ติดต่อ');
            ?>

            <?= $form->field($model, 'product_line')->textInput() ?>

            <?= $form->field($model, 'product_facebook')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'product_telephone')->textInput(['type' => 'number']) ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่  
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?=
                        $form->field($model, 'product_image_contact')->widget(FileInput::className(), [
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
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/product/' . $model->product_image_contact, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'product_image_contact')->widget(FileInput::className(), [
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
                <a href="<?= Url::to(['product/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>