<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="culture-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'topic_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\Topic::find()->all(), 'topic_id', 'topic_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกประเภทบทความ...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('ประเภทบทความ'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>