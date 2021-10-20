<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->tourism_province_name;
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียดจังหวัดท่องเที่ยว', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tourism_province_name, 'url' => ['view', 'id' => $model->tourism_province_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    
</div>