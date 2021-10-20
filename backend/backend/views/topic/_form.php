<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="culture-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'topic_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true])->label('ชื่อประเภทบทความ') ?>
    
    <?= $form->field($model, 'topic_slug')->textInput(['maxlength' => true])->label('Slug') ?>   
   
    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['topic/index']); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
