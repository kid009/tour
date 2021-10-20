<?php

use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;

$this->title = $model->special_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มอาชีพ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->special_group_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->special_group_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <div class="table-responsive">
            <?php foreach ($data as $value) : ?>
                <?php
                $special_group_latitude = $value['special_group_latitude'];
                $special_group_longitude = $value['special_group_longitude'];
                ?>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ชื่อชุมชน</th>
                        <td><?php echo $value['community_name']; ?></td>
                    </tr>

                    <tr>
                        <th>กลุ่มอาชีพ</th>
                        <td><?php echo $value['special_group_name']; ?></td>
                    </tr>

                    <tr>
                        <th>ผู้ติดต่อ</th>
                        <td><?php echo $value['special_group_contact_person']; ?></td>
                    </tr>

                    <tr>
                        <th>เบอร์โทรศัพท์</th>
                        <td><?php echo $value['special_group_telephone']; ?></td>
                    </tr>

                    <tr>
                        <th>อีเมล์</th>
                        <td><?php echo $value['special_group_email']; ?></td>
                    </tr>

                    <tr>
                        <th>Line</th>
                        <td><?php echo $value['special_group_line']; ?></td>
                    </tr>

                    <tr>
                        <th>รายละเอียด</th>
                        <td><?php echo $value['special_group_detail']; ?></td>
                    </tr>

                </table>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div id="mapid" style="width: 100%; height: 300px;"></div>
            </div>

        </div>

    <?php endforeach; ?>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle"><em class="fa fa-toggle-up"></em></span>
                &nbsp; บุคคลในกลุ่มอาชีพ
                <a class="btn btn-success pull-right" href="<?php echo Url::to(['/special-group-people/create', 'special_group_id' => $value['special_group_id'], 'community_id' => $value['community_id']]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center;">ภาพ</th>
                            <th style="text-align: center;">สมาชิกกลุ่ม</th>
                            <th style="text-align: center;">เบอร์โทรศัพท์</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <?php foreach ($specialGroupPeople as $specialGroupPeoples) : ?>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">
                                    <?php echo Html::img('@web/uploads/community/' . $model->community_id . '/people/' . $specialGroupPeoples['people_image'], ['style' => 'width: 100px;height:100px;']); ?>
                                </td>
                                <td><?php echo $specialGroupPeoples['people_name']; ?></td>
                                <td><?php echo $specialGroupPeoples['people_telephone']; ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <a class="btn btn-warning" href="<?php echo Url::to([
                                                                            'special-group-people/update',
                                                                            'id' => $specialGroupPeoples['special_group_people_id'],
                                                                            'special_group_id' => $specialGroupPeoples['special_group_id'],
                                                                            'community_id' => $model->community_id
                                                                        ]); ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-trash"></i>',
                                        [
                                            'special-group-people/delete',
                                            'id' => $specialGroupPeoples['special_group_people_id'],
                                        ],
                                        [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    <?php echo "var latitude = '$special_group_latitude'; " ?>
    <?php echo "var longitude = '$special_group_longitude'; " ?>
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