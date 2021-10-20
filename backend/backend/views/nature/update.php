<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->nature_name;
$this->params['breadcrumbs'][] = ['label' => 'สถานที่ธรรมชาติ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nature_name, 'url' => ['view', 'id' => $model->nature_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    
</div>
