<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="homestay-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'community_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
                'language' => 'th',
                'options' => [
                    'id' => 'ddl-community',
                    'placeholder' => 'เลือกชุมชน...'
                ],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชุมชน');
    } else {
        $user = $session['user_login'];
        $data = Yii::$app->db->createCommand("select community_id from community where create_by = '$user' ")->queryAll();
        echo $form->field($model, 'community_id')->hiddenInput(['value' => $data[0]['community_id']])->label(false);
    }
    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'homestay_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Homestay::find()->all(), 'homestay_id', 'homestay_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกโฮมสเตย์...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อโฮมสเตย์');
    } else {
        echo $form->field($model, 'homestay_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Homestay::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'homestay_id', 'homestay_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกโฮมสเตย์...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อโฮมสเตย์');
    }

    ?>

    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>