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
    
        echo $form->field($model, 'researcher_innovation_group_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchInnovationGroup::find()->all(), 'researcher_innovation_group_id', 'researcher_innovation_group_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('กลุ่มนวัตกรรม');
    
    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'researcher_innovation_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchInnovation::find()->all(), 'researcher_innovation_id', 'researcher_innovation_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'กลุ่มนวัฒกรรม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อนวัฒกรรม');
    } 
    else{
        echo $form->field($model, 'researcher_innovation_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchInnovation::find()
                ->where(['create_by' => $session['user_login']])
                ->all(), 'researcher_innovation_id', 'researcher_innovation_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'กลุ่มนวัฒกรรม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อนวัฒกรรม');
    }
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>