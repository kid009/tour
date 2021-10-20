<?php
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use app\models\Province;

$province = Province::find()->all();
$arrProvince = ArrayHelper::map($province, 'province_id', 'province_name');
$this->params['breadcrumbs'][] = ['label' => 'แผนที่ชุมชน', 'url' => ['index']];
?>

<div class="alert alert-default">
    <h1>แผนที่ชุมชน (Community Map)</h1>
</div>

<div class="container-fluid">
    
    <div class="row">
        
        <div class="col-md-3">
            <?php $formProvince = ActiveForm::begin(['action' => ['map/province']]); ?>
            <div class="input-group">
                <?php
                //dropdown จังหวัด
                echo $formProvince->field($model, 'province_id')->dropDownList($arrProvince, [
                    'name' => 'province',
                    'prompt' => 'เลือกจังหวัด',
                    'value' => Yii::$app->session->get('province')
                ])->label(FALSE)
                ?>
                <div class="input-group-btn" style="padding-top: 10px;">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-3">
            <?php $formAmphur = ActiveForm::begin(['action' => ['map/amphur']]); ?>
            <div class="input-group">
                <?php
                //dropdown จังหวัด
                echo $formAmphur->field($model, 'amphur_id')->dropDownList($arrAmphur, [
                    'name' => 'amphur',
                    'prompt' => 'เลือกอำเภอ',
                    'value' => Yii::$app->session->get('amphur')
                ])->label(FALSE);
                ?>
                <div class="input-group-btn" style="padding-top: 10px;">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-3">
            <?php $formDistrict = ActiveForm::begin(['action' => ['map/district']]); ?>
            <div class="input-group">
                <?php
                echo $formDistrict->field($model, 'tambon_id')->dropDownList($arrDistrict, [
                    'name' => 'district',
                    'prompt' => 'เลือกตำบล',
                    'value' => Yii::$app->session->get('district')
                ])->label(FALSE);
                ?>
                <input type="hidden" name="province" value="<?php echo Yii::$app->session->get('province') ?>">
                <input type="hidden" name="amphur" value="<?php echo Yii::$app->session->get('amphur') ?>">
                <div class="input-group-btn" style="padding-top: 10px;">
                    <?php echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="col-md-3">
            <?php $formCommunity = ActiveForm::begin(['action'=>['map/commu']]); ?>
            <div class="input-group">
                <?php
                echo $formCommunity->field($model, 'community_id')->dropDownList($arrCommu, 
                        [
                            'name'=>'commu',
                            'prompt'=>'เลือกหมู่บ้าน',
                            'value' => Yii::$app->session->get('community')
                        ])->label(FALSE);
                ?>
                <input type="hidden" name="province" value="<?php echo Yii::$app->session->get('province') ?>">
                <input type="hidden" name="amphur" value="<?php echo Yii::$app->session->get('amphur') ?>">
                <input type="hidden" name="amphur" value="<?php echo Yii::$app->session->get('district') ?>">
                <div class="input-group-btn" style="padding-top: 10px;">
                    <?php echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        
    </div>
    
</div>

<br>
<?php require 'symbol.php'; ?>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtthCMWzEd6YywMZnkVRo-NH0WVQPtRks&callback=myMap">
</script>
<script>
    var map;
    var jsonCom = <?php echo $jsonCom; ?>;
    var mapTambonHeadman = <?php echo $jsonTambonHeadman; ?>;
    var mapVillageHeadman = <?php echo $jsonVillageHeadman; ?>;
    var mapLocalWisdom = <?php echo $jsonLocalWisdom; ?>;
    var jsonNature = <?php echo $jsonNature ?>;
    var jsonCareer = <?php echo $jsonCareer ?>;
    var jsonPrasat = <?php echo $jsonPrasat ?>;
    var jsonMuseum = <?php echo $jsonMuseum ?>;
    var jsonReligious = <?php echo $jsonReligious ?>;
    var jsonHospital = <?php echo $jsonHospital ?>;
    var jsonPolice = <?php echo $jsonPolice ?>;
    var jsonTour = <?php echo $jsonTour ?>;
    var jsonRestaurant = <?php echo $jsonRestaurant ?>;
    var jsonHotel = <?php echo $jsonHotel ?>;
    var jsonGas = <?php echo $jsonGas ?>;
    
    var infowindow;
    
    var icon = "http://127.0.0.1/tourismweb/backend/uploads/icon/";
    var iconCommu = icon + "home.png";
    var iconHeader = icon + "header.png";
    var iconHumam = icon + "human.png";
    var iconNature = icon + "nature.png";
    var iconCareer = icon + "career.png";
    var iconPrasat = icon + "tower.png";
    var iconMuseum = icon + "museum.png";
    var iconReligious = icon + "building.png";
    var iconHospital = icon + "hospital.png";
    var iconPolice = icon + "police.png";
    var iconTour = icon + "tour.png";
    var iconRestaurant = icon + "restaurant.png";
    var iconHotel = icon + "hotel.png";
    var iconGas = icon + "gas.png";
    var iconTouristplace = icon + "tourist.png";
    var iconVillageHeadman = icon + "villageheadman.png";
    var iconLocalWisdom = icon + "localwisdom.png";
    var iconTambonHeadman = icon + "tambonheadman.png";
    
    function myMap()
    {
        var uluru = {lat: 14.96404430, lng: 101.94755060};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: uluru
        });
        infowindow = new google.maps.InfoWindow();
        Commu();
        TambonHeadman();
        VillageHeadman();
        LocalWisom();
        Nature();
        Career();
        Prasat();
        Museum();
        Religious();
        Hospital();
        Police();
        Tour();
        Restaurant();
        Hotel();
        Gas();
        /*var myParser = new geoXML3.parser({map: map});
        myParser.parse('/rrcr/backend/kml/buriram.kml');
        myParser.parse('/rrcr/backend/kml/nakhonratchasima.kml');
        myParser.parse('/rrcr/backend/kml/sisaket.kml');
        myParser.parse('/rrcr/backend/kml/surin.kml');
        myParser.parse('/rrcr/backend/kml/siemreap.kml');
        myParser.parse('/rrcr/backend/kml/oddar.kml');*/
       // Touristplace();
    } //function myMap()
    
    function selectLocation(data,iconImg)
    {
        for (var i = 0; i < data.length; i++)
        {
            var Name = data[i].name;  
            var Lat = data[i].lat;
            var Lng = data[i].lng;
            var latlng = new google.maps.LatLng(Lat, Lng);
            
            var content = Name;
            
            var markeroption = {
                map: map,
                position: latlng,
                icon: iconImg,
                html: content
            };
            var marker = new google.maps.Marker(markeroption);
            
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });
        }//for
    }//function
    
    function Commu()
    {
        selectLocation(jsonCom, iconCommu);
    }//function

    function TambonHeadman()
    {
        selectLocation(mapTambonHeadman, iconTambonHeadman);
    }//function

    function VillageHeadman()
    {
        selectLocation(mapVillageHeadman, iconVillageHeadman);
    }//function

    function LocalWisom()
    {
        selectLocation(mapLocalWisdom, iconLocalWisdom);
    }//function

    function Nature()
    {
        selectLocation(jsonNature, iconNature);
    }//function

    function Career()
    {
        selectLocation(jsonCareer, iconCareer);
    }//function

    function Prasat()
    {
        selectLocation(jsonPrasat, iconPrasat);
    }//function

    function Museum()
    {
        selectLocation(jsonMuseum, iconMuseum);
    }//function

    function Religious()
    {
        selectLocation(jsonReligious, iconReligious);
    }//function

    function Hospital()
    {
        selectLocation(jsonHospital, iconHospital);
    }//function

    function Police()
    {
        selectLocation(jsonPolice, iconPolice);
    }//function

    function Tour()
    {
        selectLocation(jsonTour, iconTour);
    }//function

    function Restaurant()
    {
        selectLocation(jsonRestaurant, iconRestaurant);
    }//function.

    function Hotel()
    {
        selectLocation(jsonHotel, iconHotel);
    }//function

    function Gas()
    {
        selectLocation(jsonGas, iconGas);
    }//function
    
</script>