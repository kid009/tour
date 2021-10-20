<?php

use yii\helpers\Html;

$this->title = $model->tourism_impressive_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มความประทับใจการเดินทาง', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

    <p style="text-align:right">
    <?=Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tourism_impressive_id], ['class' => 'btn btn-warning'])?>
        <?=
Html::a('ลบข้อมูล', ['delete', 'id' => $model->tourism_impressive_id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
        'method' => 'post',
    ],
])
?>
    </p>

        <div class="table-responsive">
            <?php foreach ($data as $value): ?>
            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/tourism' . '/impressive/' . $value['tourism_impressive_image_cover'], ['style' => 'height:300px;width:300px;']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">



                        <tr>
                            <th>ชื่อกลุ่มความประทับใจการเดินทาง</th>
                            <td><?php echo $value['tourism_impressive_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อความประทับใจการเดินทาง</th>
                            <td><?php echo $value['tourism_impressive_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $value['tourism_impressive_name_en']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['tourism_impressive_detail']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $value['tourism_impressive_detail_en']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์วีดีโอ</th>
                            <td><?php echo $value['tourism_impressive_vdo']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์</th>
                            <td><?php echo $value['tourism_impressive_link']; ?></td>
                        </tr>


                    </table>
                </div>

            </div>

            <?php endforeach;?>
        </div>

    </div>
</div>