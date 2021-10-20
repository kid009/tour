<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="culture-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'culture_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\CultureGroup::find()->all(), 'culture_group_id', 'culture_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่มสถานที่...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มวัฒนธรรม'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>