<?php

use yii\helpers\Html;

$this->title = $model->bussiness_product_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มผลิตภัฑณ์ธุรกิจ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

    <p style="text-align:right">
    <?=Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->bussiness_product_id], ['class' => 'btn btn-warning'])?>
        <?=
Html::a('ลบข้อมูล', ['delete', 'id' => $model->bussiness_product_id], [
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
                    <?php echo Html::img('@web/uploads/bussiness' . '/product/' . $value['bussiness_product_image_cover'], ['style' => 'height:300px;width:300px;']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">



                        <tr>
                            <th>ชื่อกลุ่มผลิตภัฑณ์ธุรกิจ</th>
                            <td><?php echo $value['bussiness_product_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อประเภทผลิตภัฑณ์ธุรกิจ</th>
                            <td><?php echo $value['bussiness_product_type_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อผลิตภัฑณ์ธุรกิจ</th>
                            <td><?php echo $value['bussiness_product_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $value['bussiness_product_name_en']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['bussiness_product_detail']; ?></td>
                        </tr>



                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $value['bussiness_product_detail_en']; ?></td>
                        </tr>

                        <tr>
                            <th>โปรโมชั่น</th>
                            <td><?php echo $value['bussiness_product_promotion']; ?></td>
                        </tr>

                        <tr>
                            <th>ราคาผลิตภัฑณ์ธุรกิจ (บาท)</th>
                            <td><?php echo $value['bussiness_product_price']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์วีดีโอ</th>
                            <td><?php echo $value['bussiness_product_vdo']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์</th>
                            <td><?php echo $value['bussiness_product_link']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

            <?php endforeach;?>
        </div>

    </div>
</div>