<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="knowhow-people-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'people_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\People::find()->all(), 'people_id', 'people_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกบุคคล...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    ); ?>

    <?php echo $form->field($model, 'knowhow_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Knowhow::find()->all(), 'knowhow_id', 'knowhow_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกความรู้...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    ); ?>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
