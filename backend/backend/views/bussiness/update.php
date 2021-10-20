<?php

$this->title = 'แก้ไขข้อมูล: ' . $model->bussiness_name;
$this->params['breadcrumbs'][] = ['label' => 'ผลิตภัณฑ์ชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bussiness_name, 'url' => ['view', 'id' => $model->bussiness_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>