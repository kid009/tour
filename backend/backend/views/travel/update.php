<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล';
$this->params['breadcrumbs'][] = ['label' => 'การเดินทาง', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->travel_id, 'url' => ['view', 'id' => $model->travel_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
