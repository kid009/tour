<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();
?>

<div class="service-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
    echo $form->field($model, 'tourism_story_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\TourismStoryGroup::find()->all(), 'tourism_story_group_id', 'tourism_story_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มเรื่องราวจากการท่องเที่ยว');
    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'tourism_story_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\TourismStory::find()->all(), 'tourism_story_id', 'tourism_story_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('เรื่องราวจากการท่องเที่ยว');
    } else {
        echo $form->field($model, 'tourism_story_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\TourismStory::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'tourism_story_id', 'tourism_story_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('เรื่องราวจากการท่องเที่ยว');
    }
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>