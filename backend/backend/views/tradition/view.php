<?php

use yii\helpers\Html;

$this->title = $model->tradition_name;
$this->params['breadcrumbs'][] = ['label' => 'ประเพณี', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tradition_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->tradition_id], [
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
                        <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/tradition/' . $value['tradition_image_cover'], ['style' => 'height:300px;width:300px;']); ?>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">

                            <tr>
                                <th>ชื่อชุมชน</th>
                                <td><?php echo $value['community_name']; ?></td>
                            </tr>

                            <tr>
                                <th>กลุ่มประเพณี</th>
                                <td><?php echo $value['global_tradition_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อประเพณี</th>
                                <td><?php echo $value['tradition_name']; ?></td>
                            </tr>

                            <tr>
                                <th>ชื่อภาษาอังกฤษ</th>
                                <td><?php echo $value['tradition_name_en']; ?></td>
                            </tr>

                            <tr>
                                <th>วันเริ่มกิจกรรม</th>
                                <td><?php echo $value['tradition_start_date']; ?></td>
                            </tr>

                            <tr>
                                <th>วันสิ้นสุดกิจกรรม</th>
                                <td><?php echo $value['tradition_end_date']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียด</th>
                                <td><?php echo $value['tradition_detail']; ?></td>
                            </tr>

                            <tr>
                                <th>รายละเอียดภาษาอังกฤษ</th>
                                <td><?php echo $value['tradition_detail_en']; ?></td>
                            </tr>

                        </table>
                    </div>

                </div>

            <?php endforeach; ?>
        </div>

    </div>
</div>