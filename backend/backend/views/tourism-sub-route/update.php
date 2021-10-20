<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->tourism_sub_route_name;
$this->params['breadcrumbs'][] = ['label' => 'เส้นทางท่องเที่ยวย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tourism_sub_route_name, 'url' => ['view', 'id' => $model->tourism_sub_route_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <div class="row">
            <div class="col-md-10">

            </div>
            <div class="col-md-2 pull-right" style="padding-top: 20px;">
                <a class="btn btn-success pull-right" href="<?= Url::to(['tourism-sub-route/view', 'id' => $model->tourism_sub_route_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> แก้ไขกิจกรรมบนเส้นทาง
                </a>
            </div>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'tourismMainRouteId' => $tourismMainRouteId
        ]) ?>
    </div>

</div>