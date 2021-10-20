<?php

use yii\helpers\Html;
use app\models\TourismSubRoute;

$tourismSubRoute = TourismSubRoute::findOne($tourism_sub_route_id);

$this->title = 'เพิ่มข้อมูล';
$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมเส้นทางท่องเที่ยว ('.$tourismSubRoute->tourism_sub_route_name.')', 'url' => ['tourism-sub-route/view', 'id' => $tourismSubRoute->tourism_sub_route_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'tourism_sub_route_id' => $tourism_sub_route_id,
        ]) ?>
    </div>

</div>