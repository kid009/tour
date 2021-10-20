<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-xs-8 col-md-offset-2">

        <?= $form->field($model, 'operation_name_th', ['enableAjaxValidation' => true])->textInput() ?>

        <?= $form->field($model, 'operation_name_en')->textInput() ?>

        <?= $form->field($model, 'operation_url', ['enableAjaxValidation' => true])->textInput() ?>

        <?= $form->field($model, 'operation_no')->textInput() ?>

        <?= $form->field($model, 'parent_id')->textInput() ?>

        <?= $form->field($model, 'display_order')->textInput() ?>

        <?= $form->field($model, 'level')->radioList([
            1 => '1', 
            2 => '2'
        ]); ?>
        <hr>
        <h5>Active</h5>
        <?php
        if ($model->isNewRecord) {
            $model->is_active = 'N';
            echo $form->field($model, 'is_active')->radioList([
                'Y' => 'Y',
                'N' => 'N'
            ])->label(FALSE);
        } else {
            echo $form->field($model, 'is_active')->radioList([
                'Y' => 'Y',
                'N' => 'N'
            ])->label(false);
        }
        ?>

        <div class="pull-right">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <a href="<?= Url::to(['operation/index']); ?>" class="btn btn-danger">
                ยกเลิก
            </a>
        </div>

    </div>
</div>

<?php ActiveForm::end(); ?>

</div>