<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;

$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);

$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerCss("#mapid { height: 300px; } ");

// $script = <<< JS

// $( "#ddlAddress" ).click(function() {
//   //alert( "Handler for .click() called." );
//   console.log('province: ',$("#ddl-province").val()); 
//   if($("#ddl-province").val() == 'เลือกจังหวัด'){
//       console.log('Error');
//   }
// });

// JS;

// $this->registerJs($script);
?>

<div class="stepwizard col-md-offset-3" style="margin-top: 10px;">
    <div class="stepwizard-row setup-panel">

        <div class="stepwizard-step">
            <a href="#step-1" class="btn btn-primary btn-circle btn-lg">1</a>
            <p>ข้อมูลทั่วไป</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-2" class="btn btn-default btn-circle btn-lg" disabled="disabled">2</a>
            <p>รายละเอียด</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-3" class="btn btn-default btn-circle btn-lg" disabled="disabled">3</a>
            <p>ตำแหน่ง</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-4" class="btn btn-default btn-circle btn-lg" disabled="disabled">4</a>
            <p>สื่อดิจิทัล</p>
        </div>

        <div class="stepwizard-step">
            <a href="#step-5" class="btn btn-default btn-circle btn-lg" disabled="disabled">5</a>
            <p>ข้อมูลติดต่อ</p>
        </div>

    </div>
</div>

<?php $form = ActiveForm::begin([]); ?>

<!-- step-1 -->
<div class="row setup-content" id="step-1">
    <div class="col-xs-8 col-md-offset-2">

        <div class="panel panel-default">

            <?= $form->field($model, 'community_name', ['enableAjaxValidation' => true])->textInput(['required' => true])->label('ชื่อชุมชน') ?>

            <?= $form->field($model, 'community_name_en')->textInput(['maxlength' => true])->label('ชื่อภาษาอังกฤษ') ?>

            <?= $form->field($model, 'community_career')->textInput(['maxlength' => true])->label('อาชีพหลักของชุมชน') ?>

            <?= $form->field($model, 'community_number_of_population')->textInput()->label('จำนวนประชากร') ?>

            <?= $form->field($model, 'community_number_of_houses')->textInput()->label('จำนวนครัวเรือน') ?>

            <?= $form->field($model, 'community_ethnicty')->textInput()->label('ภาษาถิ่น') ?>

            <div class="panel-body">
                <h4>Active</h4>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if ($model->isNewRecord) {
                            $model->active = 'N';
                            echo $form->field($model, 'active')->radioList([
                                'Y' => 'Y',
                                'N' => 'N'
                            ])->label(FALSE);
                        } else {
                            echo $form->field($model, 'active')->radioList([
                                'Y' => 'Y',
                                'N' => 'N'
                            ])->label(false);
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="pull-right">
            <button class="btn btn-primary nextBtn" type="button" id="nextBtnName">ต่อไป</button>
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
                    $form->field($model, 'community_detail')->widget(CKEditor::className(), [
                        //'options' => ['rows' => 3],
                        'preset' => 'standard',
                    ])->label('รายละเอียดภาษาไทย')
                    ?>

                    <?=
                    $form->field($model, 'community_detail_en')->widget(CKEditor::className(), [
                        //'options' => ['rows' => 3],
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

<!-- step-3 -->
<div class="row setup-content" id="step-3">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <div class="panel panel-default">

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
                                    'url' => Url::to(['/community/get-tambon'])
                                ]
                            ])->label('ตำบล')
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'amphur_id')->widget(DepDrop::classname(), [
                                'options' => [
                                    'id' => 'ddl-amphur',
                                    'required' => true
                                ],
                                'data' => $amphur,
                                'pluginOptions' => [
                                    'depends' => ['ddl-province'],
                                    'placeholder' => 'เลือกอำเภอ...',
                                    'url' => Url::to(['/community/get-amphur']),

                                ],
                            ])->label('อำเภอ')
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($model, 'province_id')->dropDownList(
                                ArrayHelper::map(
                                    \app\models\Province::find()->all(),
                                    'province_id',
                                    'province_name'
                                ),
                                [
                                    'id' => 'ddl-province',
                                    'prompt' => 'เลือกจังหวัด',
                                    // 'prompt' => [
                                    //     'text' => 'เลือกจังหวัด',
                                    //     'options' => ['value' => 'เลือกจังหวัด']
                                    // ]
                                ]

                            )->label('จังหวัด');
                            ?>
                        </div>
                    </div>
                </div>

                <h4>ตำแหน่ง</h4>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="mapid"></div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $lat = $model->community_latitude;
                            $long = $model->community_longitude;

                            echo $form->field($model, 'community_latitude')->textInput()->label('ละติจูด');
                            echo $form->field($model, 'community_longitude')->textInput()->label('ลองติจูด');
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="ddlAddress">ต่อไป</button>
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
                        รูปภาพชุมชน
                    </div>

                    <div class="panel-body">
                        <?php
                        echo $form->field($model, 'community_image_cover')->widget(FileInput::className(), [
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
                        รูปภาพชุมชน
                    </div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <?= Html::img('@web/uploads/community/' . $model->community_image_cover, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'community_image_cover')->widget(FileInput::className(), [
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

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพหน้าปก
                    </div>

                    <div class="panel-body">
                        <?= $form->field($model, 'community_image_background_cover')->widget(FileInput::className(), [
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
                            <?php echo Html::img('@web/uploads/community/background/' . $model->community_image_background_cover, ['style' => 'height:100px;weidth:100px;'])
                            ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'community_image_background_cover')->widget(FileInput::className(), [
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

            <?= $form->field($model, 'community_vdo')->textInput()->label('วีดีโอ') ?>

            <?= $form->field($model, 'community_link')->textInput()->label('ลิงค์') ?>

            <div class="pull-right">
                <button class="btn btn-primary prevBtn" type="button">ก่อนหน้า</button>
                <button class="btn btn-primary nextBtn" type="button" id="ddlAddress">ต่อไป</button>
            </div>

        </div>
    </div>
</div>

<!-- step-5 -->
<div class="row setup-content" id="step-5">
    <div class="col-xs-8 col-md-offset-2">
        <div class="col-md-12">

            <?= $form->field($model, 'community_contact')->textInput()->label('ชื่อผู้ติดต่อ'); ?>

            <?= $form->field($model, 'community_telephone')->textInput(['type' => 'number'])->label('เบอร์โทรศัพท์ (ตัวอย่าง 0819895656)'); ?>

            <?= $form->field($model, 'community_email')->textInput(['maxlength' => true])->label('email'); ?>

            <?= $form->field($model, 'community_facebook')->textInput(['maxlength' => true])->label('facebook'); ?>

            <?= $form->field($model, 'community_line')->textInput(['maxlength' => true])->label('line'); ?>

            <?= $form->field($model, 'community_instagram')->textInput(['maxlength' => true])->label('Instragram'); ?>

            <?php if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่  
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รูปภาพผู้ติดต่อ
                    </div>

                    <div class="panel-body">
                        <?php
                        echo $form->field($model, 'community_image_contact')->widget(FileInput::className(), [
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
                            <?= Html::img('@web/uploads/community/' . $model->community_image_contact, ['style' => 'height:100px;weidth:100px;']) ?>
                            <br><br>
                        </div>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($model, 'community_image_contact')->widget(FileInput::className(), [
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
                <a href="<?= Url::to(['community/index']); ?>" class="btn btn-danger">
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

            document.getElementById('community-community_latitude').value = location.coords.latitude;
            document.getElementById('community-community_longitude').value = location.coords.longitude;
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

            document.getElementById('community-community_latitude').value = lat;
            document.getElementById('community-community_longitude').value = long;
        });
    }
</script>