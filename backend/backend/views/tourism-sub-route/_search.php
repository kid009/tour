<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="tourism-sub-route-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
    <?php echo $form->field($model, 'tourism_main_route_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\TourismMainRoute::find()->all(), 'tourism_main_route_id', 'tourism_main_route_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือก...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('เส้นทางท่องเที่ยวหลัก'); ?>
    
    <?php echo $form->field($model, 'tourism_sub_route_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\TourismSubRoute::find()->all(), 'tourism_sub_route_id', 'tourism_sub_route_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือก...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('เส้นทางท่องเที่ยวย่อย'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
