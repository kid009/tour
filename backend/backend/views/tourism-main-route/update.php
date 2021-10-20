<?php

use yii\helpers\Url;

$this->title = 'แก้ไขข้อมูล: ' . $model->tourism_main_route_name;
$this->params['breadcrumbs'][] = ['label' => 'เส้นทางท่องเที่ยวหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tourism_main_route_name, 'url' => ['view', 'id' => $model->tourism_main_route_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="pull-right" style="padding-top: 20px;">
        <a class="btn btn-success pull-right" href="<?= Url::to(['tourism-main-route/view', 'id' => $model->tourism_main_route_id]); ?>">
            <span class="glyphicon glyphicon-plus"></span> แก้ไขกิจกรรมย่อย
        </a>
    </div>
    <hr>
    <div class="panel-body">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>