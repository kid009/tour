<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->role_name;
$this->params['breadcrumbs'][] = ['label' => 'จัดการสิทธิ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role_name, 'url' => ['view', 'id' => $model->role_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'operations' => $operations,
            'role_id' => $role_id,
            'modelRoleOperation' => $modelRoleOperation,
            'operationIdOld' => $operationIdOld,
        ]) ?>
    </div>

</div>