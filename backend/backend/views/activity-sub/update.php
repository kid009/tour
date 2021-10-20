<?php

use yii\helpers\Html;
use app\models\Activity;

$activity = Activity::findOne($activity_id);

$this->title = 'แก้ไขข้อมูล: '.$model->activity_sub_name;
$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมหลัก ('.$activity->activity_name.')', 'url' => ['activity/view', 'id' => $activity_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูลกิจกรรมย่อย';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'activity_id' => $activity_id,
        ]) ?>
    </div>

</div>