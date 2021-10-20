<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->bussiness_service_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มบริการธุรกิจ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bussiness_service_group_name, 'url' => ['view', 'id' => $model->bussiness_service_group_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?=$this->render('_form', [
    'model' => $model,
])?>
    </div>

</div>