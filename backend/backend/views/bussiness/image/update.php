<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เพิ่มภาพธุรกิจ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bussiness_image_name, 'url' => ['view', 'bussiness_image_id' => $model->bussiness_image_id]];
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