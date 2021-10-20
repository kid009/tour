<?php

use yii\helpers\Html;

$this->title = $model->best_study_name;
$this->params['breadcrumbs'][] = ['label' => 'Best Study', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->best_study_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->best_study_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <hr>
        <?php foreach ($data as $value) : ?>

            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/beststudy/' . $value['best_study_image_cover'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>สินค้า</th>
                            <td><?php echo $value['product_id']; ?></td>

                        </tr>

                        <tr>
                            <th>Best Study</th>
                            <td><?php echo $value['best_study_name']; ?></td>
                        </tr>

                        <tr>
                            <th>VDO</th>
                            <td><?php echo $value['best_study_vdo']; ?></td>
                        </tr>

                        <tr>
                            <th>Line</th>
                            <td><?php echo $value['best_study_line']; ?></td>
                        </tr>

                        <tr>
                            <th>Facebook</th>
                            <td><?php echo $value['best_study_facebook']; ?></td>
                        </tr>

                        <tr>
                            <th>ผลลัพธ์</th>
                            <td><?php echo $value['best_study_result']; ?></td>
                        </tr>

                        <tr>
                            <th>การนำไปใช้ประโยชน์</th>
                            <td><?php echo $value['best_study_apply']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['best_study_detail']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>
