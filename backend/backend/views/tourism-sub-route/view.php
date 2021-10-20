<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $model->tourism_sub_route_name;
$this->params['breadcrumbs'][] = ['label' => 'เส้นทางท่องเที่ยวย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .updownbtn {
        font-size: 25px;
    }               
");
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tourism_sub_route_id, 'from' => "", 'tourismMainRouteId' => "$model->tourism_main_route_id"], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->tourism_sub_route_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <div class="row">
            <div class="col-md-4">
                <?php echo Html::img('@web/uploads/tourism/' . $model->tourism_sub_route_image_cover, ['style' => 'height:250px;width:300px;']); ?>
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <?php foreach ($data as $value) : ?>
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>เส้นทางท่องเที่ยวหลัก</th>
                                <td>
                                    <a href="<?= Url::to(['tourism-main-route/view', 'id' => $value['tourism_main_route_id']]); ?>">
                                        <?php echo $value['tourism_main_route_name']; ?>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <th>เส้นทางท่องเที่ยวย่อย</th>
                                <td><?php echo $value['tourism_sub_route_name']; ?></td>
                            </tr>

                            <tr>
                                <th>เส้นทางท่องเที่ยวย่อยภาษาอังกฤษ</th>
                                <td><?php echo $value['tourism_sub_route_name_en']; ?></td>
                            </tr>

                            <tr>
                                <th>ลำดับเส้นทางท่องเที่ยว</th>
                                <td><?php echo $value['tourism_sub_route_order']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['tourism_sub_route_detail']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดภาษาอังกฤษ</th>
                                <td><?php echo $value['tourism_sub_route_detail_en']; ?></td>
                            </tr>

                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="clickable panel-toggle "><em class="fa fa-toggle-up"></em></span>
                &nbsp; กิจกรรมบนเส้นทาง
                <a class="btn btn-success pull-right" href="<?= Url::to(['tourism-sub-route-activity/create', 'tourism_sub_route_id' => $model->tourism_sub_route_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>จังหวัด</th>
                            <th>หมู่บ้าน</th>
                            <th>กิจกรรม</th>
                            <th>เวลาทำกิจกรรม</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($tourismSubRouteActivity as $tourismSubRouteActivitys) : ?>
                            <tr data-index="<?php echo $tourismSubRouteActivitys['tourism_sub_route_activity_id'] ?>" data-position="<?php echo $tourismSubRouteActivitys['tourism_sub_route_activity_order'] ?>">
                                <td><?php echo $tourismSubRouteActivitys['tourism_sub_route_activity_order'] ?></td>
                                <td><?php echo $tourismSubRouteActivitys['province_name'] ?></td>
                                <td><?php echo $tourismSubRouteActivitys['community_name'] ?></td>
                                <td><?php echo $tourismSubRouteActivitys['activity_name'] ?></td>
                                <td><?php echo $tourismSubRouteActivitys['activity_duration'] . ' นาที' ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-edit"></i>',
                                        [
                                            'tourism-sub-route-activity/update',
                                            'id' => $tourismSubRouteActivitys['tourism_sub_route_activity_id'],
                                            'tourism_sub_route_id' => $tourismSubRouteActivitys['tourism_sub_route_id']
                                        ],
                                        [
                                            'class' => 'btn btn-warning'
                                        ]
                                    );
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a('<i class="glyphicon glyphicon-trash"></i>', [
                                        'tourism-sub-route-activity/delete',
                                        'id' => $tourismSubRouteActivitys['tourism_sub_route_activity_id'],
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

<?php
$this->registerJs(
    "
        $(document).ready(function () {
            $('table tbody').sortable({
                update: function(event, ui){
                   $(this).children().each(function(index){
                       if($(this).attr('data-position') !== (index+1)){
                           $(this).attr('data-position', (index+1)).addClass('update');
                       }
                   });

                   saveNewPosition();
                }
            });
    
            function saveNewPosition(){
               var positions = []; 
               $('.update').each(function(){
                    positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                    $(this).removeClass('update');
               });

               $.ajax({
                  url: 'index.php?r=tourism-sub-route/view&id=$model->tourism_sub_route_id',
                  method: 'POST',
                  dataType: 'text',
                  data: {
                      update: 1,
                      positions: positions
                  },
                  success: function(response){
                      console.log(response);
                  }
               });
            }

        });
    "
);
?>