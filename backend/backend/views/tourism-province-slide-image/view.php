<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TourismProvinceSlideImage */

$this->title = $model->tourism_province_slide_image_id;
$this->params['breadcrumbs'][] = ['label' => 'Tourism Province Slide Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tourism-province-slide-image-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tourism_province_slide_image_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tourism_province_slide_image_id], [
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
            'tourism_province_slide_image_id',
            'tourism_province_silde_image_name',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
        ],
    ]) ?>

</div>
