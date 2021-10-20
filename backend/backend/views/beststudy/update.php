<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->best_study_name;
$this->params['breadcrumbs'][] = ['label' => 'Best Study', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->best_study_name, 'url' => ['view', 'id' => $model->best_study_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>