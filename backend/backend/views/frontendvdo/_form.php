<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="nature-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'frontend_vdo_name')->textInput(['maxlength' => true])->label("Link Name"); ?>

    <?= $form->field($model, 'frontend_vdo_link')->textInput(['maxlength' => true])->label("Link VDO"); ?>
    
    <?= $form->field($model, 'frontend_vdo_order')->textInput(['maxlength' => true])->label("Order"); ?>

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary']) ?>
        <a href="<?= Url::to(['frontendvdo/index']); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

<?php ActiveForm::end(); ?>

</div>
