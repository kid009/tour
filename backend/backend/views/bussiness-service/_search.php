<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();
?>

<div class="culture-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?php

    echo $form->field($model, 'bussiness_service_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\BussinessServiceGroup::find()->all(), 'bussiness_service_group_id', 'bussiness_service_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('กลุ่มบริการธุรกิจงานวิจัย');

    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'bussiness_service_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\BussinessService::find()->all(), 'bussiness_service_id', 'bussiness_service_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกบริการธุรกิจ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อบริการธุรกิจ');
    } else {
        echo $form->field($model, 'bussiness_service_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\BussinessService::find()->where(['create_by' => $session['user_login']])->all(), 'bussiness_service_id', 'bussiness_service_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกบริการธุรกิจ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อบริการธุรกิจ');
    }

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>