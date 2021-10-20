<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="tourism-province-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
    echo $form->field($model, 'province_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\Province::find()->all(), 'province_id', 'province_name'),
        'language' => 'th',
        'options' => [
            'placeholder' => 'เลือกจังหวัด...'
        ],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]
    ])->label('จังหวัด');
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>