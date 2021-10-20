<?php

use yii\helpers\Html;
use yii\helpers\Json;

$this->title = $model->place_name;
$this->params['breadcrumbs'][] = ['label' => 'สถานที่ประวัติศาสตร์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->place_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->place_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <hr>

        <div class="table-responsive">

            <?php foreach ($data as $value) : ?>

                <?php
                $place_latitude = $value['place_latitude'];
                $place_longitude = $value['place_longitude'];
                ?>

                <div class="row">

                    <div class="col-md-4">
                        <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/place/' . $value['place_image_cover'], ['style' => 'height:250px;width:300px;']); ?>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อชุมชน</th>
                                <td><?php echo $value['community_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกลุ่มสถานที่ประวัติศาสตร์</th>
                                <td><?php echo $value['place_group_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อสถานที่ประวัติศาสตร์</th>
                                <td><?php echo $value['place_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อสถานที่ภาษาอังกฤษ</th>
                                <td><?php echo $value['place_name_en']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['place_detail']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดภาษาอังกฤษ</th>
                                <td><?php echo $value['place_detail_en']; ?></td>
                            </tr>

                            <tr>
                                <th>ผู้ดูแลสถานที่</th>
                                <td><?php echo $value['place_contact_person']; ?></td>
                            </tr>

                            <tr>
                                <th>เบอร์โทรศัพท์</th>
                                <td><?php echo $value['place_telephone']; ?></td>
                            </tr>

                            <tr>
                                <th>Link VDO</th>
                                <td><?php echo $value['place_vdo']; ?></td>
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
</div>

<script>
    <?php echo "var latitude = '$place_latitude'; " ?>
    <?php echo "var longitude = '$place_longitude'; " ?>
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