<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'กลุ่มวัฒนธรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->culture_group_name, 'url' => ['view', 'id' => $model->culture_group_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>