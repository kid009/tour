<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เพิ่มภาพเรื่องราวจากการท่องเที่ยว', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tourism_image_name, 'url' => ['view', 'tourism_image_id' => $model->tourism_image_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'data' => $data,
            'id' => $id,
        ]) ?>
    </div>

</div>