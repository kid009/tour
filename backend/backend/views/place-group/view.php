<?php

use yii\helpers\Html;

$this->title = $model->place_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มสถานที่ประวัติศาสตร์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->place_group_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->place_group_id], [
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
            <table class="table table-striped table-bordered">

                <tr>
                    <th>ชื่อกลุ่มสถานที่ประวัติศาสตร์</th>
                    <td><?php echo $model->place_group_name; ?></td>

                </tr>

                <tr>
                    <th>ชื่อกลุ่มสถานที่ประวัติศาสตร์ภาษาอังกฤษ</th>
                    <td><?php echo $model->place_group_name_en; ?></td>
                </tr>

                <tr>
                    <th>รายละเอียด</th>
                    <td><?php echo $model->place_group_detail; ?></td>
                </tr>

                <tr>
                    <th>รายละเอียดภาษาอังกฤษ</th>
                    <td><?php echo $model->place_group_detail_en; ?></td>
                </tr>

            </table>
        </div>

    </div>
</div>