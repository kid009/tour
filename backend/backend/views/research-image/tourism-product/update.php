<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เพิ่มภาพผลิตภัณฑ์', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->research_image_name, 'url' => ['view', 'research_image_id' => $model->research_image_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'tourism' => $tourism,
            'researcher_tourism_product_id' => $researcher_tourism_product_id,
        ]) ?>
    </div>

</div>