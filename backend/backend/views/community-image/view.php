<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityImage */

$this->title = $model->community_image_id;
$this->params['breadcrumbs'][] = ['label' => 'Community Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="community-image-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->community_image_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->community_image_id], [
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
            'community_image_id',
            'community_id',
            'community_image_name',
            'community_image_type',
            'community_image_subtype',
            'ref_id',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'community_image_file',
        ],
    ]) ?>

</div>
