<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\TourismMainRoute;
?>

<div class="tourism-main-route-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'tourism_main_route_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(TourismMainRoute::find()->all(), 'tourism_main_route_id', 'tourism_main_route_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือก...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('เส้นทางท่องเที่ยวหลัก'); ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>