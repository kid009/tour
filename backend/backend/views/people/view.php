<?php

use yii\helpers\Html;
use yii\helpers\Json;

$this->title = $model->people_name;
$this->params['breadcrumbs'][] = ['label' => 'บุคคล', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->people_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->people_id], [
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

            <div class="table-responsive">

                <?php
                $people_latitude = $value['people_latitude'];
                $people_longitude = $value['people_longitude'];
                ?>

                <div class="row">

                    <div class="col-md-4">
                        <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/people/' . $value['people_image'], ['style' => 'height:250px;width:300px;']); ?>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อชุมชน</th>
                                <td><?php echo $value['community_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกลุ่มบุคคล</th>
                                <td><?php echo $value['people_group_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อบุคคล</th>
                                <td><?php echo $value['people_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ที่อยู่ชุมชน</th>
                                <td><?php echo  $value['people_address'] . ' ตำบล' . $value['tambon_name'] . ' อำเภอ' . $value['amphur_name'] . $value['province_name']; ?></td>
                            </tr>

                            <tr>
                                <th>เบอร์โทรศัพท์</th>
                                <td><?php echo $value['people_telephone']; ?></td>
                            </tr>

                            <tr>
                                <th>line</th>
                                <td><?php echo $value['people_line']; ?></td>
                            </tr>

                            <tr>
                                <th>อีเมล์</th>
                                <td><?php echo $value['people_email']; ?></td>
                            </tr>

                            <tr>
                                <th>การศึกษา</th>
                                <td><?php echo $value['people_education']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['people_detail']; ?></td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div id="mapid" style="width: 100%; height: 300px;"></div>
                    </div>

                </div>


            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    <?php echo "var latitude = '$people_latitude'; " ?>
    <?php echo "var longitude = '$people_longitude'; " ?>
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