<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'องค์ความรู้ธุรกิจชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bussiness_knowhow_name, 'url' => ['view', 'id' => $model->bussiness_knowhow_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?=$this->render('_form', [
    'model' => $model,
])?>
    </div>

</div>