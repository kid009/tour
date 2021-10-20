<?php

use yii\helpers\Html;

$this->title = $model->tourism_province_name;
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียดจังหวัดท่องเที่ยว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tourism_province_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->tourism_province_id], [
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
                <table class="table table-striped table-bordered">

                    <tr>
                        <th>ชื่อจังหวัด</th>
                        <td><?php echo $value['tourism_province_name']; ?></td>
                    </tr>

                    <tr>
                        <th>ชื่อภาษาอังกฤษ</th>
                        <td><?php echo $value['tourism_province_name_en']; ?></td>
                    </tr>

                    <tr>
                        <th>ลำดับ</th>
                        <td><?php echo $value['tourism_province_order']; ?></td>
                    </tr>

                    <tr>
                        <th>รายละเอียด</th>
                        <td><?php echo $value['tourism_province_detail']; ?></td>
                    </tr>

                    <tr>
                        <th>รายละเอียดภาษาอังกฤษ</th>
                        <td><?php echo $value['tourism_province_detail_en']; ?></td>
                    </tr>

                    <!--<tr>
                        <th>รูปหน้า site/index</th>
                        <td><?php //echo Html::img('@web/uploads/frontend/' . $value['tourism_province_image_1'], ['style' => 'width: 300px;height:200px;']); ?></td>
                    </tr>

                    <tr>
                        <th>รูปหน้า site/province</th>
                        <td><?php //echo Html::img('@web/uploads/frontend/' . $value['tourism_province_image_2'], ['style' => 'width: 300px;height:200px;']); ?></td>
                    </tr>

                    <tr>
                        <th>รูปแผนที่หน้า site/province</th>
                        <td><?php //echo Html::img('@web/uploads/frontend/' . $value['tourism_province_image_3'], ['style' => 'width: 300px;height:200px;']); ?></td>
                    </tr>

                    <tr>
                        <th>Infomation</th>
                        <td><?php //echo $value['tourism_province_info']; ?></td>
                    </tr>-->

                </table>
            <?php endforeach; ?>
        </div>
    </div>
</div>