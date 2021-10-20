<?php

use yii\helpers\Html;

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'สินค้าชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->product_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->product_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <hr>
        <?php foreach ($data as $value) : ?>
            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/community/' . $value['community_id'] . '/product/' . $value['product_image_cover'], ['style' => 'height:250px;width:300px;']); ?>
                </div>

                <div class="col-md-8">
                    <div class="table-responsive">
                        <?php foreach ($data as $value) : ?>
                            <table class="table table-striped table-bordered">

                                <tr>
                                    <th>ชื่อชุมชน</th>
                                    <td><?php echo $value['community_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>กลุ่มอาชีพ</th>
                                    <td><?php echo $value['special_group_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>กลุ่มสินค้า</th>
                                    <td><?php echo $value['product_group_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>ชื่อสินค้า</th>
                                    <td><?php echo $value['product_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>ราคาสินค้า</th>
                                    <td><?php echo number_format($value['product_price'], 2) . ' บาท'; ?></td>
                                </tr>

                                <tr>
                                    <th>จำนวนคงเหลือ</th>
                                    <td><?php echo $value['product_stock_total'] . ' ' . $value['product_unit']; ?></td>
                                </tr>

                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <td><?php echo $value['product_code']; ?></td>
                                </tr>

                                <tr>
                                    <th>รายละเอียด</th>
                                    <td><?php echo $value['product_detail']; ?></td>
                                </tr>

                                <tr>
                                    <th>contact</th>
                                    <td><?php echo $value['product_contact_name']; ?></td>
                                </tr>

                                <tr>
                                    <th>info</th>
                                    <td><?php echo $value['product_info']; ?></td>
                                </tr>

                                <tr>
                                    <th>telephone</th>
                                    <td><?php echo $value['product_telephone']; ?></td>
                                </tr>

                                <tr>
                                    <th>line</th>
                                    <td><?php echo $value['product_line']; ?></td>
                                </tr>

                                <tr>
                                    <th>facebook</th>
                                    <td><?php echo $value['product_facebook']; ?></td>
                                </tr>

                            </table>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>