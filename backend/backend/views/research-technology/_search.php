<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
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
        echo $form->field($model, 'researcher_technology_group_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchTechnologyGroup::find()->all(), 'researcher_technology_group_id', 'researcher_technology_group_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('กลุ่มเทคโนโลยี');
    // } else {
    //     echo $form->field($model, 'researcher_technology_group_id')->widget(
    //         Select2::className(),
    //         [
    //             'data' => ArrayHelper::map(\app\models\ResearchTechnologyGroup::find()
    //                 ->where(['create_by' => $session['user_login']])
    //                 ->all(), 'researcher_technology_group_id', 'researcher_technology_group_name'),
    //             'language' => 'th',
    //             'options' => ['placeholder' => 'เลือกกลุ่ม...'],
    //             'pluginOptions' => [
    //                 'allowClear' => TRUE
    //             ]
    //         ]
    //     )->label('กลุ่มเทคโนโลยี');
    // }
    ?>

    <?php 
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'researcher_technology_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchTechnology::find()
                ->all(), 'researcher_technology_id', 'researcher_technology_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกเทคโนโลยี...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อเทคโนโลยี'); 
    }
    else{
        echo $form->field($model, 'researcher_technology_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchTechnology::find()
                ->where(['create_by' => $session['user_login']])
                ->all(), 'researcher_technology_id', 'researcher_technology_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกเทคโนโลยี...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อเทคโนโลยี'); 
    }
    
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>