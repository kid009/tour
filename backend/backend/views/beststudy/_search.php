<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="knowhow-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'product_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\Product::find()->all(), 'product_id', 'product_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกสินค้า...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('สินค้า'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>