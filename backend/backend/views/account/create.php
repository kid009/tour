<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลผู้ใช้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'modelUserRole' => $modelUserRole,
        ]) ?>
    </div>

</div>