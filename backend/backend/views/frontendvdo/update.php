<?php

use yii\helpers\Html;

$this->title = 'แก้ไข้อมูล';
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูล VDO หน้า HOME', 'url' => ['index']];
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
