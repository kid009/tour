<?php

use yii\helpers\Html;

$this->title = $model->global_tradition_name;
$this->params['breadcrumbs'][] = ['label' => 'ประเพณีทั่วไป', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->global_tradition_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['<span class="glyphicon glyphicon-trash"></span> ลบข้อมูล', 'id' => $model->global_tradition_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <hr>
        <div class="table-responsive">

            <table class="table table-striped table-bordered">

                <tr>
                    <th>ชื่อกลุ่มประเพณี</th>
                    <td><?php echo $model->global_tradition_name; ?></td>

                </tr>

                <tr>
                    <th>ชื่อภาษาอังกฤษ</th>
                    <td><?php echo $model->global_tradition_name_en; ?></td>
                </tr>

                <tr>
                    <th>รายละเอียด</th>
                    <td><?php echo $model->global_tradition_detail; ?></td>
                </tr>

                <tr>
                    <th>รายละเอียดภาษาอังกฤษ</th>
                    <td><?php echo $model->global_tradition_detail_en; ?></td>
                </tr>

            </table>

        </div>

    </div>
</div>