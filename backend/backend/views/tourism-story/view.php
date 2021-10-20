<?php

use yii\helpers\Html;

$this->title = $model->tourism_story_name;
$this->params['breadcrumbs'][] = ['label' => 'เรื่องราวจากการท่องเที่ยว', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->tourism_story_id], ['class' => 'btn btn-warning']) ?>
            <?=
            Html::a('ลบข้อมูล', ['delete', 'id' => $model->tourism_story_id], [
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
                    <?php echo Html::img('@web/uploads/tourism/story/' . $value['tourism_story_image_cover'], ['style' => 'height:250px;width:300px;', 'class' => 'img-thumbnail']); ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <th>กลุ่ม</th>
                            <td><?php echo $value['tourism_story_group_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อ</th>
                            <td><?php echo $value['tourism_story_name']; ?></td>
                        </tr>

                        <tr>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <td><?php echo $value['tourism_story_name_en']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียด</th>
                            <td><?php echo $value['tourism_story_detail']; ?></td>
                        </tr>

                        <tr>
                            <th>รายละเอียดภาษาอังกฤษ</th>
                            <td><?php echo $value['tourism_story_detail_en']; ?></td>
                        </tr>

                        <tr>
                            <th>วีดีโอ</th>
                            <td><?php echo $value['tourism_story_vdo']; ?></td>
                        </tr>

                        <tr>
                            <th>ลิงค์</th>
                            <td><?php echo $value['tourism_story_link']; ?></td>
                        </tr>

                        <tr>
                            <th>Active</th>
                            <td><?php echo $value['is_active']; ?></td>
                        </tr>

                    </table>
                </div>

            </div>

        <?php endforeach; ?>
        
    </div>
</div>