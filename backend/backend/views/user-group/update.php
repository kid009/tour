<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->user_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มผู้ใช้', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_group_name, 'url' => ['view', 'id' => $model->user_group_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="panel panel-default">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>