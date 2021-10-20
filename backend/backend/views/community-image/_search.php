<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityImageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="community-image-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'community_image_id') ?>

    <?= $form->field($model, 'community_id') ?>

    <?= $form->field($model, 'community_image_name') ?>

    <?= $form->field($model, 'community_image_type') ?>

    <?= $form->field($model, 'community_image_subtype') ?>

    <?php // echo $form->field($model, 'ref_id') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'community_image_file') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
