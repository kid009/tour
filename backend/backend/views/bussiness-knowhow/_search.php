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
    echo $form->field($model, 'bussiness_knowhow_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\BussinessKnowhowGroup::find()->all(), 'bussiness_knowhow_group_id', 'bussiness_knowhow_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('กลุ่มองค์ความรู้ธุรกิจงานวิจัย');
    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'bussiness_knowhow_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\bussinessknowhow::find()->all(), 'bussiness_knowhow_id', 'bussiness_knowhow_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกองค์ความรู้ธุรกิจ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อองค์ความรู้ธุรกิจ');
    } else {
        echo $form->field($model, 'bussiness_knowhow_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\bussinessknowhow::find()->where(['create_by' => $session['user_login']])->all(), 'bussiness_knowhow_id', 'bussiness_knowhow_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกองค์ความรู้ธุรกิจ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อองค์ความรู้ธุรกิจ');
    }

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>