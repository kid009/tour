<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivitySpecialGroup */

$this->title = $model->activity_special_group_id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Special Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-special-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->activity_special_group_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->activity_special_group_id], [
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
            'activity_id',
            'activity_special_group_id',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'special_group_id',
        ],
    ]) ?>

</div>
