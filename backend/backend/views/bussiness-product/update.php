<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'ผลิตภัฑณ์ธุรกิจชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bussiness_product_name, 'url' => ['view', 'id' => $model->bussiness_product_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?=$this->render('_form', [
    'model' => $model,
])?>
    </div>

</div>