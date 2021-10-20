<?php
use app\models\Activity;
use yii\helpers\Html;

$activity = Activity::findOne($activity_id);

$this->title = 'แก้ไขข้อมูลสถานที่กลุ่มอาชีพในกิจกรรม';
$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมหลัก ('.$activity->activity_name.')', 'url' => ['activity/view', 'id' => $activity_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูลสถานที่กลุ่มอาชีพในกิจกรรม';
?>
<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'activity_id' => $activity_id,
        ]) ?>
    </div>

</div>