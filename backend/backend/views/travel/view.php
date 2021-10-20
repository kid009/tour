<?php

use yii\helpers\Json;
use yii\helpers\Html;

$this->title = $model->travel_contact;
$this->params['breadcrumbs'][] = ['label' => 'การเดินทาง', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="padding-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->travel_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->travel_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <hr>
        <?php foreach ($data as $value) : ?>
            <?php
            $arrJson = [];

            $travel_latitude = $value['travel_latitude'];
            $travel_longitude = $value['travel_longitude'];

            $arr = []; //array
            $arr['travel_latitude'] = $travel_latitude;
            $arr['travel_longitude'] = $travel_longitude;

            array_push($arrJson, $arr);

            $json = Json::encode($arrJson);
            ?>

            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/travel/' . $value['travel_image_map'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>ชื่อชุมชน</th>
                            <td><?php echo $value['community_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อกลุ่มการเดินทาง</th>
                            <td><?php echo $value['travel_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อผู้ติดต่อ</th>
                            <td><?php echo $value['travel_contact']; ?></td>
                        </tr>

                        <tr>
                            <th>เบอร์โทรศัพท์</th>
                            <td><?php echo $value['travel_telephone']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['travel_detail']; ?></td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div id="mapid" style="width: 100%; height: 300px;"></div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>

<script>
    <?php echo "var latitude = '$travel_latitude'; " ?>
    <?php echo "var longitude = '$travel_longitude'; " ?>
    var latlng = new L.LatLng(latitude, longitude);

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
</script>