<?php

use yii\helpers\Html;

$this->title = $model->tourism_experience_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มประสบการณ์การท่องเที่ยว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

    <p style="text-align:right">
    <?=Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tourism_experience_id], ['class' => 'btn btn-warning'])?>
        <?=
Html::a('ลบข้อมูล', ['delete', 'id' => $model->tourism_experience_id], [
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
                    <?php echo Html::img('@web/uploads/tourism' . '/experience/' . $value['tourism_experience_image_cover'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">



                        <tr>
                            <th>ชื่อกลุ่มประสบการณ์การท่องเที่ยว</th>
                            <td><?php echo $value['tourism_experience_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อประสบการณ์การท่องเที่ยว</th>
                            <td><?php echo $value['tourism_experience_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $value['tourism_experience_name_en']; ?></td>
                        </tr>

                        <tr>
                            <th>สถานที่</th>
                            <td><?php echo $value['tourism_experience_place']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['tourism_experience_detail']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $value['tourism_experience_detail_en']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์วีดีโอ</th>
                            <td><?php echo $value['tourism_experience_vdo']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์</th>
                            <td><?php echo $value['tourism_experience_link']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

            <?php endforeach;?>
        </div>

    </div>
</div>