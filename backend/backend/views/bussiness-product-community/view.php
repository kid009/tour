<?php

use yii\helpers\Html;

$this->title = $model->bussiness_product_community_name;
$this->params['breadcrumbs'][] = ['label' => 'ผลิตภัณฑ์ชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->bussiness_product_community_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->bussiness_product_community_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?php foreach ($data as $value) : ?>

            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/bussiness/product_community/' . $value['bussiness_product_community_image_cover'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>กลุ่ม</th>
                            <td><?php echo $value['bussiness_product_community_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชุมชน</th>
                            <td><?php echo $value['community_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อ</th>
                            <td><?php echo $value['bussiness_product_community_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $value['bussiness_product_community_name_en']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['bussiness_product_community_detail']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $value['bussiness_product_community_detail_en']; ?></td>
                        </tr>

                        <tr>
                            <th>เรื่องราว</th>
                            <td><?php echo $value['bussiness_product_community_story']; ?></td>
                        </tr>

                        <tr>
                            <th>วีดีโอ</th>
                            <td><?php echo $value['bussiness_product_community_vdo']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์</th>
                            <td><?php echo $value['bussiness_product_community_link']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

        <?php endforeach; ?>

        <!-- <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>ชื่อกลุ่ม</th>
                    <td><?php //echo $model->bussiness_product_community_name; 
                        ?></td>
                </tr>

                <tr>
                    <th>ชื่อกลุ่มภาษาอังกฤษ</th>
                    <td><?php //echo $model->bussiness_product_community_name_en; 
                        ?></td>
                </tr>

                <tr>
                    <th>รายละเอียด</th>
                    <td><?php //echo $model->bussiness_product_community_detail; 
                        ?></td>
                </tr>

                <tr>
                    <th>รายละเอียดภาษาอังกฤษ</th>
                    <td><?php //echo $model->bussiness_product_community_detail_en; 
                        ?></td>
                </tr>
            </table>
        </div> -->

    </div>
</div>