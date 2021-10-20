<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\Session;
?>

<div class="activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
    $session = new Session();
    $session->open();

    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'user_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\User::find()->all(), 'user_id', 'user_login'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกข้อมูล...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อผู้ใช้');
    } else {
        echo $form->field($model, 'user_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\User::find()->where(['user_login' => $session['user_login']])->all(), 'user_id', 'user_login'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกข้อมูล...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อผู้ใช้');
    }
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>