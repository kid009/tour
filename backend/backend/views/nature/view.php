<?php

use yii\helpers\Json;
use yii\helpers\Html;

$this->title = $model->nature_name;
$this->params['breadcrumbs'][] = ['label' => 'สถานที่ธรรมชาติ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->nature_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->nature_id], [
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
                $nature_latitude = $value['nature_latitude'];
                $nature_longitude = $value['nature_longitude'];
                ?>

                <div class="row">

                    <div class="col-md-4">
                        <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/nature/' . $value['nature_image_cover'], ['style' => 'height:250px;width:300px;']); ?>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อชุมชน</th>
                                <td><?php echo $value['community_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกลุ่มสถานที่</th>
                                <td><?php echo $value['nature_group_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อสถานที่</th>
                                <td><?php echo $value['nature_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อสถานที่ภาษาอังกฤษ</th>
                                <td><?php echo $value['nature_name_en']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['nature_detail']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดภาษาอังกฤษ</th>
                                <td><?php echo $value['nature_detail_en']; ?></td>
                            </tr>

                            <tr>
                                <th>ผู้ดูแลสถานที่</th>
                                <td><?php echo $value['nature_caretaker']; ?></td>
                            </tr>

                            <tr>
                                <th>เบอร์โทรศัพท์</th>
                                <td><?php echo $value['nature_telephone']; ?></td>
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
    <?php echo "var latitude = '$nature_latitude'; " ?>
    <?php echo "var longitude = '$nature_longitude'; " ?>
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