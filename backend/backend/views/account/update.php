<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->user_login;
$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลผู้ใช้', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'modelUserRole' => $modelUserRole,
        ]) ?>
    </div>

</div>