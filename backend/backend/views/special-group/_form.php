<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\Session;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;

$session = new Session();
$session->open();

$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);

$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerCss("#mapid { height: 300px; } ");

$user = $session['user_login'];
$data = Yii::$app->db->createCommand("select community_id from community where create_by = '$user' ")->queryAll();
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
            <p>สื่อดิจิทัล</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>ตำแหน่ง</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-5" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">5</a>
            <p>ข้อมูลติดต่อ</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

<!-- Step 1 -->
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
            if ($session['user_login'] == 'admin') {
                echo $form->field($model, 'knowhow_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\Knowhow::find()
                            ->all(), 'knowhow_id', 'knowhow_name'),
                        'language' => 'th',
                        'options' => [
                            'placeholder' => 'เลือกกลุ่มความรู้...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ]
                    ]
                )->label('กลุ่มความรู้');
            } else {
                $community_id = $data[0]['community_id'];
                echo $form->field($model, 'knowhow_id')->widget(
                    Select2::className(),
                    [
                        'data' => ArrayHelper::map(\app\models\Knowhow::find()
                            ->where(['community_id' => $community_id])
                            ->all(), 'knowhow_id', 'knowhow_name'),
                        'language' => 'th',
                        'options' => [
                            'placeholder' => 'เลือกกลุ่มความรู้...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => TRUE
                        ]
                    ]
                )->label('กลุ่มความรู้');
            }

            ?>

            <?= $form->field($model, 'special_group_name')->textInput(['maxlength' => true])->label('กลุ่มอาชีพ') ?>

            <?= $form->field($model, 'special_group_name_en')->textInput(['maxlength' => true])->label('กลุ่มอาชีพภาษาอังกฤษ') ?>



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

            <?= $form->field($model, 'special_group_detail')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'standard',
            ])->label('รายละเอียด') ?>

            <?= $form->field($model, 'special_group_detail_en')->widget(CKEditor::className(), [
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

<!-- step-3 -->
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
                        <?=
                        $form->field($model, 'special_group_image_cover')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/special_group/' . $model->special_group_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'special_group_image_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'special_group_vdo')->textInput()->label('วีดีโอ'); ?>

            <?= $form->field($model, 'special_group_link')->textInput()->label('ลิงค์'); ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- Step4 -->
<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    ตำแหน่ง
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="mapid"></div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $lat = $model->special_group_latitude;
                            $long = $model->special_group_longitude;

                            echo $form->field($model, 'special_group_latitude')->textInput()->label('ละติจูด');
                            echo $form->field($model, 'special_group_longitude')->textInput()->label('ลองติจูด');
                            ?>

                        </div>
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

<!-- Step5 -->
<div class="row setup-content" id="step-5">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'special_group_contact_person')->textInput()->label('ชื่อผู้ติดต่อ'); ?>

            <?= $form->field($model, 'special_group_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

            <?= $form->field($model, 'special_group_email')->textInput(['maxlength' => true])->label('email'); ?>

            <?= $form->field($model, 'special_group_facebook')->textInput(['maxlength' => true])->label('facebook'); ?>

            <?= $form->field($model, 'special_group_line')->textInput(['maxlength' => true])->label('line'); ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่  
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?=
                        $form->field($model, 'special_group_image_contact')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/community/' . $model->community_id . '/special_group/' . $model->special_group_image_contact, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'special_group_image_contact')->widget(FileInput::className(), [
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

<script>
    <?php echo "var lat = '$lat'; " ?>
    <?php echo "var long = '$long'; " ?>

    if (lat == "" && long == "") {
        navigator.geolocation.getCurrentPosition(function(location) {
            var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);

            var mymap = L.map('mapid').setView(latlng, 13);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicG9uZ3Bvb20iLCJhIjoiY2txdGk4OHkwMWpzcDJzbmJxeXFnMHVtZyJ9.mJ9FrZH8wybzE3tS31CZlQ', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoicG9uZ3Bvb20iLCJhIjoiY2txdGk4OHkwMWpzcDJzbmJxeXFnMHVtZyJ9.mJ9FrZH8wybzE3tS31CZlQ'
            }).addTo(mymap);

            var marker = L.marker(latlng).addTo(mymap);

            document.getElementById('specialgroup-special_group_latitude').value = location.coords.latitude;
            document.getElementById('specialgroup-special_group_longitude').value = location.coords.longitude;
        });
    } else {

        navigator.geolocation.getCurrentPosition(function(location) {
            var latlng = new L.LatLng(lat, long);

            var mymap = L.map('mapid').setView(latlng, 13);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicG9uZ3Bvb20iLCJhIjoiY2txdGk4OHkwMWpzcDJzbmJxeXFnMHVtZyJ9.mJ9FrZH8wybzE3tS31CZlQ', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoicG9uZ3Bvb20iLCJhIjoiY2txdGk4OHkwMWpzcDJzbmJxeXFnMHVtZyJ9.mJ9FrZH8wybzE3tS31CZlQ'
            }).addTo(mymap);

            var marker = L.marker(latlng).addTo(mymap);

            document.getElementById('specialgroup-special_group_latitude').value = lat;
            document.getElementById('specialgroup-special_group_longitude').value = long;
        });
    }
</script>