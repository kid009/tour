<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="global-tradition-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'global_tradition_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\GlobalTradition::find()->all(), 'global_tradition_id', 'global_tradition_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่มประเพณี...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มประเพณี'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>