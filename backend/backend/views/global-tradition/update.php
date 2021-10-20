<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->global_tradition_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มประเพณี', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->global_tradition_name, 'url' => ['view', 'id' => $model->global_tradition_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>