<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Province; //ข้อมูลจังหวัด
use yii\helpers\ArrayHelper;

$province = Province::find()->all();
$arrProvince = ArrayHelper::map($province, 'province_id', 'province_name');
$this->params['breadcrumbs'][] = ['label' => 'แผนที่ชุมชน', 'url' => ['index']];
?>
<div class="alert alert-default">
    <h1>แผนที่ชุมชน (Community Map)</h1>
</div>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <?php $formProvince = ActiveForm::begin(['action' => ['map/province']]); ?>
            <div class="input-group">
                <?php
                //dropdown จังหวัด
                echo $formProvince->field($model, 'province_id')->dropDownList($arrProvince, [
                    'name' => 'province',
                    'prompt' => 'เลือกจังหวัด',
                    'value' => Yii::$app->session->get("province")
                ])->label(FALSE)
                ?>
                <div class="input-group-btn" style="padding-top: 10px;">
                    <?php echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">
            <?php $formAmphur = ActiveForm::begin(['action' => ['map/amphur']]); ?>
            <div class="input-group">
                <?php
                //dropdown จังหวัด
                echo $formAmphur->field($model, 'amphur_id')->dropDownList($arrAmphur, [
                    'name' => 'amphur',
                    'prompt' => 'เลือกอำเภอ'
                ])->label(FALSE);
                ?> 
                <input type="hidden" name="province" value="<?php echo Yii::$app->session->get("province") ?>">
                <div class="input-group-btn" style="padding-top: 10px;">
                    <?php echo Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class' => 'btn btn-primary']) ?>
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
    var mapJsoncommu = <?php echo $jsonCommu ?>;
    var mapTambonHeadman = <?php echo $jsonTambonHeadman; ?>;
    var mapVillageHeadman = <?php echo $jsonVillageHeadman; ?>;
    var mapLocalWisdom = <?php echo $jsonLocalWisdom; ?>;
    var mapNature = <?php echo $jsonNature ?>;
    var mapCareer = <?php echo $jsonCareer ?>;
    var mapPrasat = <?php echo $jsonPrasat ?>;
    var mapMuseum = <?php echo $jsonMuseum ?>;
    var mapHotel = <?php echo $jsonHotel ?>;
    var mapReligious = <?php echo $jsonReligious ?>;
    var mapHospital = <?php echo $jsonHospital ?>;
    var mapPolice = <?php echo $jsonPolice ?>;
    var mapTour = <?php echo $jsonTour ?>;
    var mapRestaurant = <?php echo $jsonRestaurant ?>;
    var mapGas = <?php echo $jsonGas ?>;
    var mapHomestay = <?php echo $jsonHomestay ?>;


    var infowindow;

    var icon = "http://127.0.0.1/tourismweb/backend/uploads/icon/";
    var iconCommu = icon + "home.png";
    var iconVillageHeadman = icon + "villageheadman.png";
    var iconNature = icon + "nature.png";
    var iconCareer = icon + "career.png";
    var iconPrasat = icon + "tower.png";
    var iconMuseum = icon + "museum.png";
    var iconReligious = icon + "building.png";
    var iconHospital = icon + "hospital.png";
    var iconPolice = icon + "police.png";
    var iconTour = icon + "tour.png";
    var iconHotel = icon + "hotel.png";
    var iconRestaurant = icon + "restaurant.png";
    var iconGas = icon + "gas.png";
    var iconTouristplace = icon + "tourist.png";
    var iconHomestay = icon + "homestay.png";
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

        Community();
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
        Hotel();
        Restaurant();
        Gas();
        Homestay();

        var myParser = new geoXML3.parser({map: map});
        /*myParser.parse('/rrcr/backend/kml/buriram.kml');
         myParser.parse('/rrcr/backend/kml/nakhonratchasima.kml');
         myParser.parse('/rrcr/backend/kml/sisaket.kml');
         myParser.parse('/rrcr/backend/kml/surin.kml');
         myParser.parse('/rrcr/backend/kml/siemreap.kml');
         myParser.parse('/rrcr/backend/kml/oddar.kml');*/
    } //function myMap()

    function selectLocation(data, iconImg)
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

    function Community()
    {
        selectLocation(mapJsoncommu, iconCommu);
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
        selectLocation(mapNature, iconNature);
    }//function

    function Career()
    {
        selectLocation(mapCareer, iconCareer);
    }//function

    function Prasat()
    {
        selectLocation(mapPrasat, iconPrasat);
    }//function

    function Museum()
    {
        selectLocation(mapMuseum, iconMuseum);
    }//function

    function Religious()
    {
        selectLocation(mapReligious, iconReligious);
    }//function

    function Hospital()
    {
        selectLocation(mapHospital, iconHospital);
    }//function

    function Police()
    {
        selectLocation(mapPolice, iconPolice);
    }//function

    function Tour()
    {
        selectLocation(mapTour, iconTour);
    }//function

    function Hotel()
    {
        selectLocation(mapHotel, iconHotel);
    }//function

    function Restaurant()
    {
        selectLocation(mapRestaurant, iconRestaurant);
    }//function

    function Gas()
    {
        selectLocation(mapGas, iconGas);
    }//function

    function Homestay()
    {
        selectLocation(mapHomestay, iconHomestay);
    }//function
</script>


