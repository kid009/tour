<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="restaurant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'researcher_research_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearcherResearch::find()
                ->all(), 'researcher_research_id', 'research_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือก...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่องานวิจัย');
    } else {
        echo $form->field($model, 'researcher_research_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearcherResearch::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'researcher_research_id', 'research_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือก...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่องานวิจัย');
    }

    ?>

    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>