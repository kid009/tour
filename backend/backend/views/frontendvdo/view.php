<?php

use yii\helpers\Html;

$this->title = $model->nature_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มสถานที่ธรรมชาติ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-md-2" style="padding-top: 20px;">
        <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->nature_group_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->nature_group_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
    </div>
</div>

<div class="panel panel-default">

    <div class="panel-body">

        <div class="table-responsive">
            <table class="table table-striped table-bordered">

                <tr>
                    <th>ชื่อกลุ่มสถานที่ธรรมชาติ</th>
                    <td><?php echo $model->nature_group_name; ?></td>

                </tr>

                <tr>
                    <th>ชื่อกลุ่มสถานที่ธรรมชาติภาษาอังกฤษ</th>
                    <td><?php echo $model->nature_group_name_en; ?></td>
                </tr>

                <tr>
                    <th>รายละเอียด</th>
                    <td><?php echo $model->nature_group_detail; ?></td>
                </tr>

                <tr>
                    <th>รายละเอียดภาษาอังกฤษ</th>
                    <td><?php echo $model->nature_group_detail_en; ?></td>
                </tr>

            </table>
        </div>

    </div>
</div>
