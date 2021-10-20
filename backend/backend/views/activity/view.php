<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->activity_name;
$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->activity_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->activity_id], [
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

                <div class="row">

                    <div class="col-md-4">
                        <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/activity/' . $value['activity_image_cover'], ['style' => 'height:250px;width:300px;']); ?>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อชุมชน</th>
                                <td><?php echo $value['community_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกลุ่มกิจกรรม</th>
                                <td><?php echo $value['activity_group_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกิจกรรม</th>
                                <td><?php echo $value['activity_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกิจกรรมภาษาอังกฤษ</th>
                                <td><?php echo $value['activity_name_en']; ?></td>
                            </tr>

                            <tr>
                                <th>อัตราค่าบริการ</th>
                                <td><?php echo $value['activity_price']; ?></td>
                            </tr>

                            <tr>
                                <th>ระยะเวลาทำกิจกรรม</th>
                                <td><?php echo $value['activity_duration'] . ' นาที'; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดระยะเวลาทำกิจกรรม</th>
                                <td><?php echo $value['activity_duration_text']; ?></td>
                            </tr>

                            <tr>
                                <th>จำนวนผู้ร่วมกิจกรรม</th>
                                <td><?php echo $value['activity_participant_min'] . ' - ' . $value['activity_participant_max'] . ' คน'; ?>
                                </td>
                            </tr>

                            <tr>
                                <th>ช่วงเวลาที่ทำกิจกรรม</th>
                                <td><?php echo $value['activity_period']; ?></td>
                            </tr>

                            <tr>
                                <th>ช่วงอายุผู้ร่วมกิจกรรม</th>
                                <td><?php echo $value['activity_participant_age'] . ' ปี'; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['activity_detail']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดภาษาอังกฤษ</th>
                                <td><?php echo $value['activity_detail_en']; ?></td>
                            </tr>

                        </table>
                    </div>

                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle "><em class="fa fa-toggle-up"></em></span>
                &nbsp; กิจกรรมย่อย
                <a class="btn btn-success pull-right" href="<?= Url::to(['activity-sub/create', 'activity_id' => $model->activity_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>กิจกรรมย่อย</th>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($activitySub as $activitySubs) : ?>
                            <tr data-index="<?php echo $activitySubs['activity_sub_id']; ?>" data-position="<?php echo $activitySubs['activity_sub_order'] ?>">
                                <td><?php echo $activitySubs['activity_sub_order'] ?></td>
                                <td><?php echo $activitySubs['activity_sub_name'] ?></td>
                                <td><?php echo $activitySubs['activity_sub_name_en'] ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-edit"></i>', [
                                        'activity-sub/update',
                                        'id' => $activitySubs['activity_sub_id'],
                                        'activity_id' => $activitySubs['activity_id']
                                    ], [
                                        'class' => 'btn btn-warning'
                                    ]);
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i>', [
                                        'activity-sub/delete',
                                        'id' => $activitySubs['activity_sub_id']
                                    ], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle "><em class="fa fa-toggle-up"></em></span>
                &nbsp; จัดกิจกรรมในสถานที่ประวัติศาสตร์
                <a class="btn btn-success pull-right" href="<?= Url::to(['activity-place/create', 'activity_id' => $model->activity_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table id="sortable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>สถานที่</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <?php foreach ($activityPlace as $activityPlaces) : ?>
                        <tbody id="sortable">
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?= $activityPlaces['place_name']; ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-edit"></i>', [
                                        'activity-place/update',
                                        'id' => $activityPlaces['activity_place_id'],
                                        'activity_id' => $activityPlaces['activity_id'],
                                    ], [
                                        'class' => 'btn btn-warning'
                                    ])
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i>', ['activity-place/delete', 'id' => $activityPlaces['activity_place_id'],], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                            'method' => 'post',
                                        ],
                                    ])
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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle "><em class="fa fa-toggle-up"></em></span>
                &nbsp; จัดกิจกรรมในสถานที่ธรรมชาติ
                <a class="btn btn-success pull-right" href="<?= Url::to(['activity-nature/create', 'activity_id' => $model->activity_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table id="sortable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>สถานที่</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        <?php foreach ($activityNature as $activityNatures) : ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?= $activityNatures['nature_name']; ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-edit"></i>', [
                                        'activity-nature/update',
                                        'id' => $activityNatures['activity_nature_id'],
                                        'activity_id' => $activityNatures['activity_id'],
                                    ], [
                                        'class' => 'btn btn-warning'
                                    ]);
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i>', ['activity-nature/delete', 'id' => $activityNatures['activity_nature_id'],], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle "><em class="fa fa-toggle-up"></em></span>
                &nbsp; จัดกิจกรรมในสถานที่โฮมสเตย์
                <a class="btn btn-success pull-right" href="<?= Url::to(['activity-homestay/create', 'activity_id' => $model->activity_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table id="sortable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>สถานที่</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        <?php foreach ($activityHomestay as $activityHomestays) : ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?= $activityHomestays['homestay_name']; ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-edit"></i>',
                                        [
                                            'activity-homestay/update',
                                            'id' => $activityHomestays['activity_homestay_id'],
                                            'activity_id' => $activityHomestays['activity_id'],
                                        ],
                                        [
                                            'class' => 'btn btn-warning'
                                        ]
                                    );
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i>', [
                                        'activity-homestay/delete',
                                        'id' => $activityHomestays['activity_homestay_id'],
                                    ], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle "><em class="fa fa-toggle-up"></em></span>
                &nbsp; จัดกิจกรรมในสถานที่ของกลุ่มอาชีพ
                <a class="btn btn-success pull-right" href="<?= Url::to(['activity-special-group/create', 'activity_id' => $model->activity_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table id="sortable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 30px;">#</th>
                            <th>สถานที่</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        <?php foreach ($activitySpecialGroup as $activitySpecialGroups) : ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?= $activitySpecialGroups['special_group_name']; ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-edit"></i>',
                                        [
                                            'activity-special-group/update',
                                            'id' => $activitySpecialGroups['activity_special_group_id'],
                                            'activity_id' => $activitySpecialGroups['activity_id'],
                                        ],
                                        [
                                            'class' => 'btn btn-warning'
                                        ]
                                    );
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i>', [
                                        'activity-special-group/delete',
                                        'id' => $activitySpecialGroups['activity_special_group_id'],
                                    ], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.row -->

<?php
$this->registerJs(
    "
            $(document).ready(function(){
                $('table tbody').sortable({
                    update: function(event, ui){
                        $(this).children().each(function(index){
                            if($(this).attr('data-position') != (index+1)){
                                $(this).attr('data-position', (index+1)).addClass('updated');
                            }
                        });
                        
                        saveNewPosition();
                    }
                });
            });
            
            function saveNewPosition()
            {
                var positions = [];
                $('.updated').each(function(){
                    positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                    $(this).removeClass('updated');
                });
                
                $.ajax({
                    url: 'index.php?r=activity/view&id=$model->activity_id',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        update: 1,
                        positions: positions
                    }, success: function(response){
                        console.log(response);
                    }
                });
            }
        "
)
?>