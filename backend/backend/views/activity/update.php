<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_name, 'url' => ['view', 'id' => $model->activity_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>


<div class="panel panel-default" style="margin-top:20px;">

    <div class="panel-body">

        <div class="pull-right">
            <a class="btn btn-success pull-right" href="<?= Url::to(['activity/view', 'id' => $model->activity_id]); ?>">
                <span class="glyphicon glyphicon-plus"></span> แก้ไขกิจกรรมย่อย
            </a>
        </div>
        <br><hr>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>

</div>