<?php

use yii\helpers\Url;

$this->title = 'สรุปผลข้อมูลท่องเที่ยว';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row" style="margin-top: 20px;">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">ข้อมูลท่องเที่ยว</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">แผนที่ท่องเที่ยว</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade in active" id="tab1">
                        <div class="panel panel-container" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                                    <div class="panel panel-teal panel-widget border-right">
                                        <div class="row no-padding">
                                            <h4><i class="fa fa-clipboard" aria-hidden="true"></i> ข้อมูลประสบการณ์</h4>
                                            <div class="large"><?= $countExprience; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                                    <div class="panel panel-blue panel-widget border-right">
                                        <div class="row no-padding">
                                            <h4><i class="fa fa-clipboard" aria-hidden="true"></i> ข้อมูลความรู้</h4>
                                            <div class="large"><?= $countKnowhow; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                                    <div class="panel panel-orange panel-widget border-right">
                                        <div class="row no-padding">
                                            <h4><i class="fa fa-clipboard" aria-hidden="true"></i> ข้อมูลความประทับใจ</h4>
                                            <div class="large"><?= $countImpressive; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                                    <div class="panel panel-red panel-widget ">
                                        <div class="row no-padding">
                                            <h4><i class="fa fa-clipboard" aria-hidden="true"></i> ข้อมูลเรื่องราว</h4>
                                            <div class="large"><?= $countStory; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/.row-->
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel ">
                                    <div class="panel-heading">
                                        Timeline ข้อมูลประสบการณ์
                                        <!-- <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span> -->
                                    </div>
                                    <div class="panel-body timeline-container">
                                        <ul class="timeline">

                                            <?php foreach ($expriences as $exprience) : ?>
                                                <li>
                                                    <div class="timeline-badge primary" style="padding-top: 12px;">
                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">
                                                                <a href="<?php echo Url::to(['tourism-experience/view', 'id' => $exprience['tourism_experience_id']]) ?>">
                                                                    <?php echo $exprience['tourism_experience_place']; ?>
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-default ">
                                    <div class="panel-heading">
                                        Timeline ข้อมูลความรู้
                                        <!-- <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span> -->
                                    </div>
                                    <div class="panel-body timeline-container">
                                        <ul class="timeline">

                                            <?php foreach ($knowhows as $knowhow) : ?>
                                                <li>
                                                    <div class="timeline-badge primary" style="padding-top: 12px;">
                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">
                                                                <a href="<?php echo Url::to(['tourism-knowhow/view', 'id' => $knowhow['tourism_knowhow_id']]) ?>">
                                                                    <?php echo $knowhow['tourism_knowhow_place']; ?>
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="panel panel-default ">
                                    <div class="panel-heading">
                                        Timeline ข้อมูลประทับใจ
                                        <!-- <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span> -->
                                    </div>
                                    <div class="panel-body timeline-container">
                                        <ul class="timeline">

                                            <?php foreach ($impressives as $impressive) : ?>
                                                <li>
                                                    <div class="timeline-badge primary" style="padding-top: 12px;">
                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">
                                                                <a href="<?php echo Url::to(['tourism-impressive/view', 'id' => $impressive['tourism_impressive_id']]) ?>">
                                                                    <?php echo $impressive['tourism_impressive_place']; ?>
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="panel panel-default ">
                                    <div class="panel-heading">
                                        Timeline ข้อมูลเรื่องราว
                                        <!-- <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span> -->
                                    </div>
                                    <div class="panel-body timeline-container">
                                        <ul class="timeline">

                                            <?php foreach ($stories as $story) : ?>
                                                <li>
                                                    <div class="timeline-badge primary" style="padding-top: 12px;">
                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">
                                                                <a href="<?php echo Url::to(['tourism-story/view', 'id' => $story['tourism_story_id']]) ?>">
                                                                    <?php echo $story['tourism_story_place']; ?>
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab2">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="mapid" style="width: 100%; height: 600px;"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/.panel-->
    </div>
    <!--/.col-->
</div><!-- /.row -->

<?php
include "db_map.php";
?>

<script>
    var latitude = '<?php echo $j_latitudes; ?>';
    var longitude = '<?php echo $j_longitudes; ?>';

    var a_latitude = JSON.parse(latitude);
    var a_longitude = JSON.parse(longitude);

    console.log(a_latitude.length);

    var latlng = new L.LatLng(a_latitude[0], a_longitude[0]);

    var mymap = L.map('mapid').setView(latlng, 8);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicG9uZ3Bvb20iLCJhIjoiY2txdGk4OHkwMWpzcDJzbmJxeXFnMHVtZyJ9.mJ9FrZH8wybzE3tS31CZlQ', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 10,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoicG9uZ3Bvb20iLCJhIjoiY2txdGk4OHkwMWpzcDJzbmJxeXFnMHVtZyJ9.mJ9FrZH8wybzE3tS31CZlQ'
    }).addTo(mymap);

    for (var i = 0; i < a_latitude.length; i++) {
        marker = new L.marker([a_latitude[i], a_longitude[i]])
            .addTo(mymap);
    }
</script>