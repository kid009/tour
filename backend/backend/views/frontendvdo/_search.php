<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="nature-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'nature_group_id') ?>
    
    <?php echo $form->field($model, 'nature_group_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\NatureGroup::find()->all(), 'nature_group_id', 'nature_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่มสถานที่...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มสถานที่'); ?>

    <?php //echo$form->field($model, 'nature_group_detail') ?>

    <?php //echo $form->field($model, 'nature_group_name_en') ?>

    <?php //echo $form->field($model, 'nature_group_detail_en') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
        <?php // echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
