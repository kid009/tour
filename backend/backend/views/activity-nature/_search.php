<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="activity-nature-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'nature_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Nature::find()->all(), 'nature_id', 'nature_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกสถานที่...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    ); ?>

    <?php echo $form->field($model, 'activity_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Activity::find()->all(), 'activity_id', 'activity_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกิจกรรม...'],
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
