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

$this->registerCss("#mapid { height: 300px; } ");
?>

<div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลสถานที่</p>
            <p>ที่เกี่ยวข้อง</p>
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
            <p>ข้อมูลติดต่อ</p>
        </div>

    </div>
</div>

<div class="poi-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

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

                <?php echo $form->field($model, 'poi_group_id')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(\app\models\PoiGroup::find()->all(), 'poi_group_id', 'poi_group_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'เลือกกลุ่มสถานที่...'],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]);
                ?>

                <?= $form->field($model, 'poi_name')->textInput(); ?>

            </div>
            <div class="pull-right">
                <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
            </div>
        </div>
    </div>

    <div class="row setup-content" id="step-2">
        <div class="col-xs-8 col-md-offset-2">
            <div class="col-md-12">

                <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            รูปภาพสถานที่
                        </div>

                        <div class="panel-body">
                            <?= $form->field($model, 'poi_image_cover')->widget(FileInput::className(), [
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
                            รูปภาพสถานที่
                        </div>

                        <div class="panel-body">
                            <div class="col-md-3">
                                <?= Html::img('@web/uploads/community/' . $model->community_id . '/poi/' . $model->poi_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                                <br><br>
                            </div>
                            <div class="col-md-9">
                                <?php
                                echo $form->field($model, 'poi_image_cover')->widget(FileInput::className(), [
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

                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= $form->field($model, 'poi_detail')->widget(CKEditor::className(), [
                            'options' => ['row' => 3],
                            'preset' => 'standard',
                        ])->label('รายละเอียดสถานที่') ?>
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
                <div class="panel panel-default">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ที่อยู่
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <?=
                                    $form->field($model, 'tambon_id')->widget(DepDrop::classname(), [
                                        'data' => $tambon,
                                        'pluginOptions' => [
                                            'depends' => ['ddl-province', 'ddl-amphur'],
                                            'placeholder' => 'เลือกตำบล...',
                                            'url' => Url::to(['/poi/get-tambon'])
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
                                            'url' => Url::to(['/poi/get-amphur'])
                                        ],
                                    ])->label('อำเภอ')
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?=
                                    $form->field($model, 'province_id')->dropDownList(
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
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="mapid"></div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $lat = $model->poi_latitude;
                                $long = $model->poi_longitude;

                                echo $form->field($model, 'poi_latitude')->textInput()->label('ละติจูด');
                                echo $form->field($model, 'poi_longitude')->textInput()->label('ลองติจูด');
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

    <div class="row setup-content" id="step-4">
        <div class="col-xs-8 col-md-offset-2">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <?= $form->field($model, 'poi_contanct_name')->textInput()->label('ชื่อผู้ดูแล'); ?>

                        <?= $form->field($model, 'poi_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)  '); ?>

                        <?= $form->field($model, 'poi_website')->textInput(); ?>

                        <?= $form->field($model, 'poi_contact_person_email')->textInput()->label('Email'); ?>

                        <?= $form->field($model, 'poi_contact_person_line')->textInput()->label('Line'); ?>

                        <?= $form->field($model, 'poi_contact_person_facebook')->textInput()->label('Fackbook'); ?>

                        <?= $form->field($model, 'poi_contact_person_instagram')->textInput()->label('Instagram'); ?>

                        <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
                        ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    รูปภาพผู้ติดต่อ
                                </div>

                                <div class="panel-body">
                                    <?= $form->field($model, 'poi_contact_person_image')->widget(FileInput::className(), [
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
                                        <?= Html::img('@web/uploads/community/' . $model->community_id . '/poi/' . $model->poi_contact_person_image, ['style' => 'height:100px;weidth:100px;']) ?>
                                        <br><br>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        echo $form->field($model, 'poi_contact_person_image')->widget(FileInput::className(), [
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
                </div>

                <div class="pull-right">
                    <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>

                    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                    <a href="<?= Url::to(['poi/index']); ?>" class="btn btn-danger">
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

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

            document.getElementById('poi-poi_latitude').value = location.coords.latitude;
            document.getElementById('poi-poi_longitude').value = location.coords.longitude;
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

            document.getElementById('poi-poi_latitude').value = lat;
            document.getElementById('poi-poi_longitude').value = long;
        });
    }
</script>