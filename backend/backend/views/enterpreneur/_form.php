<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;

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
            <p>ข้อมูลทั่วไป</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>ข้อมูลติดต่อ</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>ตำแหน่ง</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?php
            // Parent 
            echo $form->field($model, 'entrepreneur_group_id')->dropDownList(
                ArrayHelper::map(\app\models\EntrepreneurGroup::find()->all(), 'entrepreneur_group_id', 'entrepreneur_group_name'),
                [
                    'id' => 'entrepreneur_group_id',
                    'prompt' => '--- เลือกข้อมูล ---'
                ]
            )->label('กลุ่มผู้ประกอบการ');
            ?>

            <?= $form->field($model, 'entrepreneur_name', ['enableAjaxValidation' => true])->textInput()->label('ชื่อธุรกิจ') ?>

            <?= $form->field($model, 'entrepreneur_knowledge')->textInput() ?>

            <?= $form->field($model, 'entrepreneur_product')->textInput() ?>

            <?= $form->field($model, 'entrepreneur_service')->textInput() ?>

            <?= $form->field($model, 'entrepreneur_local_product')->textInput() ?>

            <?= $form->field($model, 'entrepreneur_information')->textInput() ?>

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

                    <?php echo $form->field($model, 'entrepreneur_telephone')->textInput(['maxlength' => true])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

                    <?php echo $form->field($model, 'entrepreneur_facebook')->textInput(['maxlength' => true])->label('Facebook'); ?>

                    <?= $form->field($model, 'entrepreneur_line')->textInput(['maxlength' => true]) ?>

                    <?php echo $form->field($model, 'entrepreneur_email')->textInput(['maxlength' => true])->label('Email'); ?>

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

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <?php
                        echo $form->field($model, 'entrepreneur_image')->widget(FileInput::className(), [
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
                        รูปภาพ
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?php echo Html::img('@web/uploads/entrepreneur/' . $model->entrepreneur_image, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'entrepreneur_image')->widget(FileInput::className(), [
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
                    <p>รายละเอียด</p>
                    <?=
                    $form->field($model, 'entrepreneur_detail')->widget(CKEditor::className(), [
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

<!-- step-4 -->
<div class="row setup-content" id="step-4">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    ที่อยู่
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'entrepreneur_address')->textarea(['rows' => 1])->label(false) ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'tambon_id')->widget(DepDrop::classname(), [
                                'data' => $tambon,
                                'pluginOptions' => [
                                    'depends' => ['ddl-province', 'ddl-amphur'],
                                    'placeholder' => 'เลือกตำบล...',
                                    'url' => Url::to(['/enterpreneur/get-tambon'])
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
                                    'url' => Url::to(['/enterpreneur/get-amphur'])
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

            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="mapid"></div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $lat = $model->entrepreneur_latitude;
                            $long = $model->entrepreneur_longitude;

                            echo $form->field($model, 'entrepreneur_latitude')->textInput()->label('ละติจูด');
                            echo $form->field($model, 'entrepreneur_longitude')->textInput()->label('ลองติจูด');
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>

                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
                <a href="<?= Url::to(['enterpreneur/index']); ?>" class="btn btn-danger">
                    ยกเลิก
                </a>
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script>
    //----- map -----
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

            document.getElementById('entrepreneur-entrepreneur_latitude').value = location.coords.latitude;
            document.getElementById('entrepreneur-entrepreneur_longitude').value = location.coords.longitude;
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

            document.getElementById('entrepreneur-entrepreneur_latitude').value = lat;
            document.getElementById('entrepreneur-entrepreneur_longitude').value = long;
        });
    }
    //----- map -----
</script>