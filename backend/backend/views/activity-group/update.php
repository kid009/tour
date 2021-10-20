<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'กลุ่มกิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_group_name, 'url' => ['view', 'id' => $model->activity_group_id]];
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