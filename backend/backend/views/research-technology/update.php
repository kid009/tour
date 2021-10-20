<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เทคโนโลยีชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->researcher_technology_name, 'url' => ['view', 'id' => $model->researcher_technology_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>