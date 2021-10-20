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
        echo $form->field($model, 'researcher_tourism_product_group_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchTourismProductGroup::find()
                    ->all(), 'researcher_tourism_product_group_id', 'researcher_tourism_product_group_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่มผลิตภัณฑ์...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('กลุ่มผลิตภัณฑ์');
    // } else {
    //     echo $form->field($model, 'researcher_tourism_product_group_id')->widget(
    //         Select2::className(),
    //         [
    //             'data' => ArrayHelper::map(\app\models\ResearchTourismProductGroup::find()
    //                 ->where(['create_by' => $session['user_login']])
    //                 ->all(), 'researcher_tourism_product_group_id', 'researcher_tourism_product_group_name'),
    //             'language' => 'th',
    //             'options' => ['placeholder' => 'เลือกกลุ่มผลิตภัณฑ์...'],
    //             'pluginOptions' => [
    //                 'allowClear' => true,
    //             ],
    //         ]
    //     )->label('กลุ่มผลิตภัณฑ์');
    // }

    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'researcher_tourism_product_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchTourismProduct::find()->all(), 'researcher_tourism_product_id', 'researcher_tourism_product_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกผลิตภัณฑ์...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อผลิตภัณฑ์');
    } else {
        echo $form->field($model, 'researcher_tourism_product_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\ResearchTourismProduct::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'researcher_tourism_product_id', 'researcher_tourism_product_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกผลิตภัณฑ์...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อผลิตภัณฑ์');
    }

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>