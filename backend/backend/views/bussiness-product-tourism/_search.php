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
    //if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'bussiness_product_tourism_group_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\BussinessProductTourismGroup::find()->all(), 'bussiness_product_tourism_group_id', 'bussiness_product_tourism_group_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('กลุ่มผลิตภัณฑ์ท่องเที่ยว');
    // } else {
    //     echo $form->field($model, 'bussiness_product_tourism_group_id')->widget(
    //         Select2::className(),
    //         [
    //             'data' => ArrayHelper::map(\app\models\BussinessProductTourismGroup::find()
    //                 ->where(['create_by' => $session['user_login']])
    //                 ->all(), 'bussiness_product_tourism_group_id', 'bussiness_product_tourism_group_name'),
    //             'language' => 'th',
    //             'options' => ['placeholder' => 'เลือกกลุ่ม...'],
    //             'pluginOptions' => [
    //                 'allowClear' => true,
    //             ],
    //         ]
    //     )->label('กลุ่มผลิตภัณฑ์ท่องเที่ยว');
    // }
    ?>

<?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'bussiness_product_tourism_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\BussinessProductTourism::find()->all(), 'bussiness_product_tourism_id', 'bussiness_product_tourism_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ผลิตภัณฑ์ท่องเที่ยว');
    } else {
        echo $form->field($model, 'bussiness_product_tourism_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\BussinessProductTourism::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'bussiness_product_tourism_id', 'bussiness_product_tourism_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกกลุ่ม...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ผลิตภัณฑ์ท่องเที่ยว');
    }
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>