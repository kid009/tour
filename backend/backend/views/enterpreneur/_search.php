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

    <?php echo $form->field($model, 'entrepreneur_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\EntrepreneurGroup::find()->all(), 'entrepreneur_group_id', 'entrepreneur_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => '--- เลือกข้อมูล ---'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มผู้ประกอบการ'); ?>

    <?php echo $form->field($model, 'entrepreneur_name')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\Entrepreneur::find()->all(), 'entrepreneur_id', 'entrepreneur_name'),
        'language' => 'th',
        'options' => ['placeholder' => '--- เลือกข้อมูล ---'],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]
    ])->label('ผู้ประกอบการ'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>