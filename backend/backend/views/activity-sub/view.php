<?php

use yii\helpers\Html;

$this->title = $model->activity_sub_name;
$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-md-2" style="padding-top: 20px;">
        <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->activity_sub_id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('ลบข้อมูล', ['delete', 'id' => $model->activity_sub_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูหรือไม่?',
                'method' => 'post',
            ],
        ])
        ?>
    </div>
</div>

<div class="panel panel-default">

    <div class="table-responsive">
        <?php foreach ($data as $value): ?>
            <table class="table table-striped table-bordered">
                
                <tr>
                    <th>ชื่อกิจกรรม</th>
                    <td><?php echo $value['activity_name']; ?></td>
                </tr>
                
                <tr>
                    <th>ชื่อกิจกรรมย่อย</th>
                    <td><?php echo $value['activity_sub_name']; ?></td>
                </tr>
                
                <tr>
                    <th>ชื่อกิจกรรมย่อยภาษาอังกฤษ</th>
                    <td><?php echo $value['activity_sub_name_en']; ?></td>
                </tr>
                
                <tr>
                    <th>ลำดับที่</th>
                    <td><?php echo $value['activity_sub_order']; ?></td>
                </tr>
                
                <tr>
                    <th>รายละเอียด</th>
                    <td><?php echo $value['activity_sub_detail']; ?></td>
                </tr>
                
                <tr>
                    <th>รายละเอียดภาษาอังกฤษ</th>
                    <td><?php echo $value['activity_sub_detail_en']; ?></td>
                </tr>
                
            </table>
        <?php endforeach; ?>
    </div>

</div>
