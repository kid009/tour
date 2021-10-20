<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'ผลิตภัณฑ์ชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->researcher_tourism_product_name, 'url' => ['view', 'id' => $model->researcher_tourism_product_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?=$this->render('_form', [
    'model' => $model,
])?>
    </div>

</div>