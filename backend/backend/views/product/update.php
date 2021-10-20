<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'ผลิตภัณฑ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'special_group' => $special_group
        ]) ?>
    </div>

</div>
