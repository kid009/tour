<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->tourism_sub_route_activity_id;
$this->params['breadcrumbs'][] = ['label' => 'Tourism Sub Route Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tourism-sub-route-activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tourism_sub_route_activity_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tourism_sub_route_activity_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tourism_sub_route_id',
            'tourism_sub_route_activity_id',
            'activity_id',
            'tourism_sub_route_activity_order',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'tourism_main_route_id',
        ],
    ]) ?>

</div>
