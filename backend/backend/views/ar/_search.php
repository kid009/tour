<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="people-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'community_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกชุมชน...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('ชื่อชุมชน'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>