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
        echo $form->field($model, 'restaurant_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Restaurant::find()->all(), 'restaurant_id', 'restaurant_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกร้านอาหาร...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อร้านอาหาร');
    } else {
        echo $form->field($model, 'restaurant_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Restaurant::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'restaurant_id', 'restaurant_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกร้านอาหาร...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อร้านอาหาร');
    }

    ?>

    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>