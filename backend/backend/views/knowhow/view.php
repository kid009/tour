<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = $model->knowhow_name;
$this->params['breadcrumbs'][] = ['label' => 'องค์ความรู้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->knowhow_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->knowhow_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?php foreach ($data as $value) : ?>

            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/knowhow/' . $value['knowhow_image_cover'], ['style' => 'height:250px;width:300px;']); ?>
                </div>

                <div class="col-md-8">
                    <div class="table-responsive">

                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อชุมชน</th>
                                <td><?php echo $value['community_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อกลุ่มความรู้</th>
                                <td><?php echo $value['knowhow_group_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อองค์ความรู้</th>
                                <td><?php echo $value['knowhow_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อองค์ความรู้ภาษาอังกฤษ</th>
                                <td><?php echo $value['knowhow_name_en']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['knowhow_detail']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดภาษาอังกฤษ</th>
                                <td><?php echo $value['knowhow_detail_en']; ?></td>
                            </tr>

                        </table>

                    </div>
                </div>

            </div>
            <hr>
            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/knowhow/' . $value['knowhow_innovation_image'], ['style' => 'height:250px;width:300px;']); ?>
                </div>
                
                <div class="col-md-8">
                <h3>นวัตกรรม</h3>
                    <div class="table-responsive">

                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อ</th>
                                <td><?php echo $value['knowhow_innovation_name']; ?></td>
                            </tr>

                            <tr>
                                <th>วัตถุดิบ</th>
                                <td><?php echo $value['knowhow_innovation_resource']; ?></td>
                            </tr>

                            <tr>
                                <th>กระบวนการ</th>
                                <td><?php echo $value['knowhow_innovation_process']; ?></td>
                            </tr>

                            <tr>
                                <th>ผลลัพท์</th>
                                <td><?php echo $value['knowhow_innovation_result']; ?></td>
                            </tr>

                            <tr>
                                <th>การนำไปใช้ประโยชน์</th>
                                <td><?php echo $value['knowhow_innovation_apply']; ?></td>
                            </tr>

                            <tr>
                                <th>วีดีโอ</th>
                                <td><?php echo $value['knowhow_innovation_vdo']; ?></td>
                            </tr>

                            <tr>
                                <th>ลิงค์</th>
                                <td><?php echo $value['knowhow_innovation_link']; ?></td>
                            </tr>

                        </table>

                    </div>
                </div>

            </div>
            <hr>
            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/knowhow/' . $value['knowhow_technology_image'], ['style' => 'height:250px;width:300px;']); ?>
                </div>

                <div class="col-md-8">
                    <h3>เทคโนโลยี</h3>
                    <div class="table-responsive">

                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อ</th>
                                <td><?php echo $value['knowhow_technology_name']; ?></td>
                            </tr>

                            <tr>
                                <th>วัตถุดิบ</th>
                                <td><?php echo $value['knowhow_technology_resource']; ?></td>
                            </tr>

                            <tr>
                                <th>กระบวนการ</th>
                                <td><?php echo $value['knowhow_technology_process']; ?></td>
                            </tr>

                            <tr>
                                <th>ผลลัพท์</th>
                                <td><?php echo $value['knowhow_technology_result']; ?></td>
                            </tr>

                            <tr>
                                <th>การนำไปใช้ประโยชน์</th>
                                <td><?php echo $value['knowhow_technology_apply']; ?></td>
                            </tr>

                            <tr>
                                <th>วีดีโอ</th>
                                <td><?php echo $value['knowhow_technology_vdo']; ?></td>
                            </tr>

                            <tr>
                                <th>ลิงค์</th>
                                <td><?php echo $value['knowhow_technology_link']; ?></td>
                            </tr>

                        </table>

                    </div>
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
                &nbsp; บุคคลในกลุ่มองค์ความรู้
                <a class="btn btn-success pull-right" href="<?php echo Url::to(['/knowhow-people/create', 'knowhow_id' => $model->knowhow_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
                </a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th style="text-align: center;">ภาพ</th>
                            <th style="text-align: center;">สมาชิกกลุ่ม</th>
                            <th style="text-align: center;">เบอร์โทรศัพท์</th>
                            <th style="text-align: center;">แก้ไขข้อมูล</th>
                            <th style="text-align: center;">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <?php foreach ($knowhowPeople as $knowhowPeoples) : ?>
                        <tbody>
                            <tr>
                                <td style="text-align: center;"><?= $n++; ?></td>
                                <td style="text-align: center;">
                                    <?php echo Html::img('@web/uploads/community/' . $model->community_id . '/people/' . $knowhowPeoples['people_image'], ['style' => 'width: 100px;height:100px;']); ?>
                                </td>
                                <td><?php echo $knowhowPeoples['people_name']; ?></td>
                                <td><?php echo $knowhowPeoples['people_telephone']; ?></td>
                                <td style="width: 150px;text-align: center;">
                                    <a class="btn btn-warning" href="<?php echo Url::to([
                                                                            'knowhow-people/update',
                                                                            'id' => $knowhowPeoples['knowhow_people_id'],
                                                                            'knowhow_id' => $knowhowPeoples['knowhow_id'],
                                                                        ]); ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                </td>
                                <td style="width: 150px;text-align: center;">
                                    <?php
                                    echo Html::a(
                                        '<i class="glyphicon glyphicon-trash"></i>',
                                        [
                                            'knowhow-people/delete',
                                            'id' => $knowhowPeoples['knowhow_people_id'],
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