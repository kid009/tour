<?php
//print_r($model);
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\widgets\FileInput;
use kartik\select2\Select2;

$this->title = 'แก้ไขข้อมูล: ' . $model->user_login;
$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลผู้ใช้', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';

//เรียกใช้ไฟล์ css
$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);
//เรียกใช้ไฟล์ js
$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
//print_r($modelUserRole);
?>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">

        <div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
            <div class="stepwizard-row setup-panel">

                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
                    <p>ข้อมูลส่วนตัว</p>
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

                    <?php echo $form->field($model, 'user_name')->textInput()->label('ชื่อ') ?>

                    <?php echo $form->field($model, 'user_surname')->textInput()->label('นามสกุล') ?>

                    <?php
                    foreach ($modelUserRole as $value) {
                        //echo 'role_id: '.$value['role_id'];
                        if ($value['role_id'] == 23) {
                            echo $form->field($model, 'user_specialize')->textInput(['maxlength' => true])->label('ความเชี่ยวชาญ');

                            echo $form->field($model, 'user_department')->textInput()->label('สาขาวิชา');

                            echo $form->field($model, 'user_course')->textInput(['maxlength' => true])->label('หลักสูตร');

                            echo $form->field($model, 'user_faculty')->textInput()->label('คณะ');

                            echo $form->field($model, 'user_university')->textInput(['maxlength' => true])->label('มหาวิทยาลัย');
                        }
                    }
                    ?>

                    <?php
                    foreach ($modelUserRole as $value) {
                        //echo 'role_id: '.$value['role_id'];
                        if ($value['role_id'] == 2) {

                            echo $form->field($model, 'user_age')->textInput(['type' => 'number'])->label('อายุ');

                            echo $form->field($model, 'user_sex')->radioList([
                                'ชาย' => 'ชาย',
                                'หญิง' => 'หญิง',
                            ])->label('เพศ');

                            echo $form->field($model, 'user_education')->radioList([
                                'ต่ำกว่า ป.6' => 'ต่ำกว่า ป.6',
                                'ป.6' => 'ป.6',
                                'ม.3' => 'ม.3',
                                'ม.6 หรือ ปวช.' => 'ม.6 หรือ ปวช.',
                                'ปวส.หรือ อนุปริญญา' => 'ปวส.หรือ อนุปริญญา',
                                'ปริญญาตรี' => 'ปริญญาตรี',
                                'ปริญญาโท' => 'ปริญญาโท',
                                'ปริญญาเอก' => 'ปริญญาเอก'
                            ])->label('การศึกษา');

                            echo $form->field($model, 'user_revenue')->textInput(['type' => 'number'])->label('รายได้');
                        }
                    }
                    ?>

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

                        <?php echo $form->field($model, 'user_address')->textInput()->label('ที่อยู่') ?>

                        <div class="row">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'tambon_id')->widget(DepDrop::classname(), [
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
                                $form->field($model, 'amphur_id')->widget(DepDrop::classname(), [
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




                                // $form->field($model, 'province_id')->dropDownList(
                                //     ArrayHelper::map(
                                //         \app\models\Province::find()->all(),
                                //         'province_id',
                                //         'province_name'
                                //     ),
                                //     [
                                //         'id' => 'ddl-province',
                                //         'prompt' => 'เลือกจังหวัด'
                                //     ]
                                // )->label('จังหวัด');
                                ?>
                            </div>
                        </div>

                        <?php echo $form->field($model, 'user_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์') ?>

                        <?php echo $form->field($model, 'user_email')->textInput(['maxlength' => true])->label('อีเมล') ?>

                        <?php echo $form->field($model, 'user_line')->textInput()->label('Line') ?>

                        <?php echo $form->field($model, 'user_facebook')->textInput(['maxlength' => true])->label('Facebook') ?>

                        <?php echo $form->field($model, 'user_instragram')->textInput()->label('Instragram') ?>

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

                        <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                        ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    รูปภาพประจำตัว
                                </div>

                                <div class="panel-body">
                                    <?= $form->field($model, 'user_image_cover')->widget(FileInput::className(), [
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
                                    รูปภาพประจำตัว
                                </div>

                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <?php echo Html::img('@web/uploads/account/' . $model->user_image_cover, ['style' => 'height:100px;weidth:100px;'])
                                        ?>
                                        <br><br>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        echo $form->field($model, 'user_image_cover')->widget(FileInput::className(), [
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

                    <div class="panel panel-default">

                        <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                        ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    รูปภาพหน้าปก
                                </div>

                                <div class="panel-body">
                                    <?= $form->field($model, 'user_image_background_cover')->widget(FileInput::className(), [
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
                                        <?php echo Html::img('@web/uploads/background/' . $model->user_image_background_cover, ['style' => 'height:100px;weidth:100px;'])
                                        ?>
                                        <br><br>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        echo $form->field($model, 'user_image_background_cover')->widget(FileInput::className(), [
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