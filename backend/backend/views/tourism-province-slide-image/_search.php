<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TourismProvinceSlideImageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tourism-province-slide-image-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tourism_province_slide_image_id') ?>

    <?= $form->field($model, 'tourism_province_silde_image_name') ?>

    <?= $form->field($model, 'create_by') ?>

    <?= $form->field($model, 'create_date') ?>

    <?= $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
