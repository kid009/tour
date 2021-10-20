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
    //if($session['user_login'] == 'admin'){
        echo $form->field($model, 'researcher_experience_group_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchExperienceGroup::find()
                    ->all(), 'researcher_experience_group_id', 'researcher_experience_group_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่มประสบการณ์...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('กลุ่มประสบการณ์'); 
    // }
    // else{
    //     echo $form->field($model, 'researcher_experience_group_id')->widget(
    //         Select2::className(),
    //         [
    //             'data' => ArrayHelper::map(\app\models\ResearchExperienceGroup::find()
    //                 ->where(['create_by' => $session['user_login']])
    //                 ->all(), 'researcher_experience_group_id', 'researcher_experience_group_name'),
    //             'language' => 'th',
    //             'options' => ['placeholder' => 'เลือกกลุ่มประสบการณ์...'],
    //             'pluginOptions' => [
    //                 'allowClear' => TRUE
    //             ]
    //         ]
    //     )->label('กลุ่มประสบการณ์'); 
    // }
    
    ?>

    <?php 
    if($session['user_login'] == 'admin'){
        echo $form->field($model, 'researcher_experience_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchExperience::find()->all(), 'researcher_experience_id', 'researcher_experience_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกประสบการณ์...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อประสบการณ์');
    }
    else{
        echo $form->field($model, 'researcher_experience_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchExperience::find()
                ->where(['create_by' => $session['user_login']])
                ->all(), 'researcher_experience_id', 'researcher_experience_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกประสบการณ์...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อประสบการณ์');
    }
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>