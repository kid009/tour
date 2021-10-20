<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->people_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มบุคคล', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->people_group_name, 'url' => ['view', 'id' => $model->people_group_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>