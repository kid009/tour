<?php

use yii\helpers\Url;
use yii\helpers\Html;
use mdm\admin\components\Helper;

$this->title = $model->tourism_main_route_name;
$this->params['breadcrumbs'][] = ['label' => 'เส้นทางท่องเที่ยวหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tourism_main_route_id], ['class' => 'btn btn-warning']) ?>
            <?php
            echo Html::a('ลบข้อมูล', ['delete', 'id' => $model->tourism_main_route_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ]);
            ?>
        </p>

        <div class="row">
            <div class="col-md-4">
                <?php echo Html::img('@web/uploads/tourism/' . $model->tourism_main_route_image, ['style' => 'height:250px;width:300px;']); ?>
            </div>

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>ชื่อเส้นทางหลัก</th>
                            <td><?php echo $model->tourism_main_route_name; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $model->tourism_main_route_name_en; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $model->tourism_main_route_detail; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $model->tourism_main_route_detail_en; ?></td>
                        </tr>

                    </table>
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
                &nbsp; เส้นทางท่องเที่ยวย่อย

                <a class="btn btn-success pull-right" href="<?php echo Url::to(['tourism-sub-route/create', 'tourismMainRouteId' => $model->tourism_main_route_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>

            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover table-bordered">

                    <thead>
                        <tr>
                            <th>ลำดับเส้นทาง</th>
                            <th>เส้นทางท่องเที่ยวย่อย</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">แก้ไขกิจกรรม</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($tourSubRoute as $tourSubRoutes) : ?>
                            <tr>
                                <td><?php echo $tourSubRoutes['tourism_sub_route_order'] ?></td>
                                <td><?php echo $tourSubRoutes['tourism_sub_route_name'] ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-edit"></i>',
                                        [
                                            'tourism-sub-route/update',
                                            'id' => $tourSubRoutes['tourism_sub_route_id'],
                                            'from' => 'tourism-main-route/view',
                                            'tourismMainRouteId' => $tourSubRoutes['tourism_main_route_id']
                                        ],
                                        [
                                            'class' => 'btn btn-warning'
                                        ]
                                    );
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-edit"></i>',
                                        [
                                            'tourism-sub-route/view',
                                            'id' => $tourSubRoutes['tourism_sub_route_id']
                                        ],
                                        //'tourism_sub_route_id' => $tourismSubRouteActivitys['tourism_sub_route_id']], 
                                        [
                                            'class' => 'btn btn-warning'
                                        ]
                                    );
                                    ?>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-trash"></i>',
                                        [
                                            'tourism-sub-route-activity/delete',
                                            'id' => $tourSubRoutes['tourism_sub_route_id'],
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
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>