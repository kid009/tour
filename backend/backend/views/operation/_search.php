<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="restaurant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
    <?php echo $form->field($model, 'operation_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Operation::find()
                    ->all(), 'operation_id', 'operation_name_th'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกข้อมูล...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('ชื่อเมนู'); ?>

    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
