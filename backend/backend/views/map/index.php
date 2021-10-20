<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Province; //ข้อมูลจังหวัด

$sqlProvince = "select  distinct community.province_id, province_name
from tb_province
inner join community on community.province_id = tb_province.province_id
order by community.province_id";
$province = Province::findBySql($sqlProvince)->all();
$arrProvince = ArrayHelper::map($province, 'province_name', 'province_name');

$session_province = Yii::$app->session->get('province');
if(empty($session_province)){
    $sqlCommunity = "select * from community";
}
else{
  $sqlCommunity = "select * from community 
        inner join tb_province on tb_province.province_id = community.province_id 
        where province_name = '$session_province' ";  
}
$community = \app\models\Community::findBySql($sqlCommunity)->all();
$arrCommunity = ArrayHelper::map($community, 'community_name', 'community_name');

$this->params['breadcrumbs'][] = ['label' => 'แผนที่ชุมชน', 'url' => ['index']];
?>
<div class="alert alert-default">
    <h1>แผนที่ชุมชน (Community Map)</h1>
</div>


    <div class="row">
        <?= Html::beginForm(['map/index'], 'post') ?>

        <div class="col-md-6">
            <div class="input-group">
                <?php
                echo Select2::widget([
                    'name' => 'province',
                    'data' => $arrProvince,
                    'value' => Yii::$app->session->get('province'),
                    'options' => ['placeholder' => 'เลือกจังหวัด ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <div class="input-group-btn">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group">
                <?php
                echo Select2::widget([
                    'name' => 'community',
                    'data' => $arrCommunity,
                    'value' => Yii::$app->session->get('community'),
                    'options' => ['placeholder' => 'เลือกชุมชน ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <div class="input-group-btn">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <?= Html::endForm() ?>
    </div>


<br>
<?php require 'symbol.php'; ?>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtthCMWzEd6YywMZnkVRo-NH0WVQPtRks&callback=myMap">
</script>

<script>
    var map;
    var mapJsoncommu = <?php echo $jsonCommunity ?>;
    var mapTambonHeadman = <?php echo $jsonTambonHeadman; ?>;
    var mapVillageHeadman = <?php echo $jsonVillageHeadman; ?>;
    var mapLocalWisdom = <?php echo $jsonLocalWisdom; ?>;
    var mapNature = <?php echo $jsonNature ?>;
    var mapCareer = <?php echo $jsonCareer ?>;
    var mapPrasat = <?php echo $jsonPrasat ?>;
    var mapMuseum = <?php echo $jsonMuseum ?>;
    var mapReligious = <?php echo $jsonReligious ?>;
    var mapHospital = <?php echo $jsonHospital ?>;
    var mapPolice = <?php echo $jsonPolice ?>;
    var mapTour = <?php echo $jsonTour ?>;
    var mapHotel = <?php echo $jsonHotel ?>;   
    var mapRestaurant = <?php echo $jsonRestaurant ?>;
    var mapHomestay = <?php echo $jsonHomestay ?>;
    var mapGas = <?php echo $jsonGas ?>;
    

    //console.log(mapTambonHeadman);

    var icon = "http://phimai-angkorwat.com/tour/backend/uploads/icon/";
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

    var infowindow;

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
        Homestay();
        Gas();

        var myParser = new geoXML3.parser({map: map});
        /*myParser.parse('/tourismweb/backend/kml/buriram.kml');
         myParser.parse('/tourismweb/backend/kml/nakhonratchasima.kml');
         myParser.parse('/tourismweb/backend/kml/sisaket.kml');
         myParser.parse('/tourismweb/backend/kml/surin.kml');
         myParser.parse('/tourismweb/backend/kml/siemreap.kml');
         myParser.parse('/tourismweb/backend/kml/oddar.kml');
         if (status === 'data')
         {
         
         }
         else 
         {
         myParser.parse('/tourismweb/backend/kml/r1.kml');
         myParser.parse('/tourismweb/backend/kml/r2.kml');
         myParser.parse('/tourismweb/backend/kml/r3.kml');
         myParser.parse('/tourismweb/backend/kml/r4.kml');
         myParser.parse('/tourismweb/backend/kml/r5.kml');
         myParser.parse('/tourismweb/backend/kml/r6.kml');
         myParser.parse('/tourismweb/backend/kml/r7.kml');
         myParser.parse('/tourismweb/backend/kml/r8.kml');
         //myParser.parse('/rrcr/backend/kml/r9.kml');
         myParser.parse('/tourismweb/backend/kml/r10.kml');
         myParser.parse('/tourismweb/backend/kml/r11.kml');
         myParser.parse('/tourismweb/backend/kml/r12.kml');
         myParser.parse('/tourismweb/backend/kml/r13.kml');
         }*/

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