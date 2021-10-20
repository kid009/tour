<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เพิ่มภาพนวัตกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->research_image_name, 'url' => ['view', 'research_image_id' => $model->research_image_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
           'model' => $model,
           'innovation' => $innovation,
           'researcher_innovation_id' => $researcher_innovation_id,
        ]) ?>
    </div>

</div>