<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->operation_name_th;
$this->params['breadcrumbs'][] = ['label' => 'จัดการการเข้าถึงข้อมูล', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->operation_name_th, 'url' => ['view', 'id' => $model->operation_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>