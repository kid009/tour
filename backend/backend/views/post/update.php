<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'บทความ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->post_title, 'url' => ['view', 'id' => $model->post_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body ">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    
</div>