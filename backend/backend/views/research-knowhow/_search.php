<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="culture-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?php
    //if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'researcher_knowhow_group_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchKnowhowGroup::find()->all(), 'researcher_knowhow_group_id', 'researcher_knowhow_group_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('กลุ่มความรู้งานวิจัย');
    // } else {
    //     echo $form->field($model, 'researcher_knowhow_group_id')->widget(
    //         Select2::className(),
    //         [
    //             'data' => ArrayHelper::map(\app\models\ResearchKnowhowGroup::find()->where(['create_by' => $session['user_login']])->all(), 'researcher_knowhow_group_id', 'researcher_knowhow_group_name'),
    //             'language' => 'th',
    //             'options' => ['placeholder' => 'เลือกกลุ่ม...'],
    //             'pluginOptions' => [
    //                 'allowClear' => true,
    //             ],
    //         ]
    //     )->label('กลุ่มความรู้งานวิจัย');
    // }
    ?>

    <?php 
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'researcher_knowhow_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Researchknowhow::find()->all(), 'researcher_knowhow_id', 'researcher_knowhow_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกความรู้...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อความรู้'); 
    }
    else{
        echo $form->field($model, 'researcher_knowhow_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Researchknowhow::find()->where(['create_by' => $session['user_login']])->all(), 'researcher_knowhow_id', 'researcher_knowhow_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกความรู้...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อความรู้'); 
    }
    
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>