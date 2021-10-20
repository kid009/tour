<?php

use yii\helpers\Html;

$this->title = $model->entrepreneur_name;
$this->params['breadcrumbs'][] = ['label' => 'ผู้ประกอบการ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->entrepreneur_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->entrepreneur_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <hr>
        <?php foreach ($data as $value) : ?>

            <?php
            $entrepreneur_latitude = $value['entrepreneur_latitude'];
            $entrepreneur_longitude = $value['entrepreneur_longitude'];
            ?>

            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/entrepreneur/' . $value['entrepreneur_image'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>ชื่อกลุ่ม</th>
                            <td><?php echo $value['entrepreneur_group_name']; ?></td>

                        </tr>

                        <tr>
                            <th>ชื่อผู้ประกอบการ</th>
                            <td><?php echo $value['entrepreneur_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ที่อยู่</th>
                            <td><?php echo $value['entrepreneur_address'] . ' ตำบล' . $value['tambon_name'] . ' อำเภอ' . $value['amphur_name'] . 'จังหวัด' . $value['province_name']; ?></td>
                        </tr>

                        <tr>
                            <th>เบอร์โทรศัพท์</th>
                            <td><?php echo $value['entrepreneur_telephone']; ?></td>
                        </tr>

                        <tr>
                            <th>Line</th>
                            <td><?php echo $value['entrepreneur_line']; ?></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td><?php echo $value['entrepreneur_email']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['entrepreneur_detail']; ?></td>
                        </tr>

                        <tr>
                            <th>knowledge</th>
                            <td>
                                <?php echo $value['entrepreneur_knowledge']  ?>
                            </td>
                        </tr>

                        <tr>
                            <th>product</th>
                            <td>
                                <?php echo $value['entrepreneur_product']  ?>
                            </td>
                        </tr>

                        <tr>
                            <th>service</th>
                            <td>
                                <?php echo $value['entrepreneur_service']  ?>
                            </td>
                        </tr>

                        <tr>
                            <th>local_product</th>
                            <td>
                                <?php echo $value['entrepreneur_local_product']  ?>
                            </td>
                        </tr>

                        <tr>
                            <th>information</th>
                            <td>
                                <?php echo $value['entrepreneur_information']  ?>
                            </td>
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
    <?php echo "var latitude = '$entrepreneur_latitude'; " ?>
    <?php echo "var longitude = '$entrepreneur_longitude'; " ?>
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