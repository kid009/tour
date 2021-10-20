<?php

use yii\helpers\Html;

$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'บทความ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

    <p style="text-align:right">
    <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->post_id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('ลบข้อมูล', ['delete', 'id' => $model->post_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                'method' => 'post',
            ],
        ])
        ?>
        </p>
        <hr>


        <?php foreach ($data as $value): ?>

            <div class="row">

                <div class="col-md-4">
                    <?php echo Html::img('@web/uploads/post/' . $value['post_image'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>ประเภทบทความ</th>
                            <td><?php echo $value['topic_name']; ?></td>

                        </tr>

                        <tr>
                            <th>ชื่อ</th>
                            <td><?php echo $value['post_title']; ?></td>
                        </tr>

                        <tr>
                            <th>Slug</th>
                            <td><?php echo $value['post_slug']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['post_detail']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>
