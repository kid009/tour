<?php

use yii\helpers\Html;

$this->title = 'แก้ไข้อมูล: '.$model->nature_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มสถานที่ธรรมชาติ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nature_group_name, 'url' => ['view', 'id' => $model->nature_group_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
