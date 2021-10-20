<?php
use app\models\TourismSubRoute;
use yii\helpers\Html;

$tourismSubRoute = TourismSubRoute::findOne($tourism_sub_route_id);

$this->title = 'แก้ไขข้อมูล: '.$model->tourismSubRoute->tourism_sub_route_name;
//$this->params['breadcrumbs'][] = ['label' => 'Tourism Sub Route Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมเส้นทางท่องเที่ยว ('.$tourismSubRoute->tourism_sub_route_name.')', 'url' => ['tourism-sub-route/view', 'id' => $tourismSubRoute->tourism_sub_route_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'tourism_sub_route_id' => $tourism_sub_route_id,
        ]) ?>
    </div>
    
</div>