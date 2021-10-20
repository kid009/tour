<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'ประสบการณ์ชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->researcher_experience_name, 'url' => ['view', 'id' => $model->researcher_experience_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>