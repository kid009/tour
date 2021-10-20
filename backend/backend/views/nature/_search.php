<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="nature-search">

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

    <?php echo $form->field($model, 'nature_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\NatureGroup::find()
                ->all(), 'nature_group_id', 'nature_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => '--- เลือกข้อมูล ---'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มสถานที่ธรรมชาติ'); ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'nature_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Nature::find()->all(), 'nature_id', 'nature_name'),
                'language' => 'th',
                'options' => ['placeholder' => '--- เลือกข้อมูล ---'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('สถานที่ธรรมชาติ');
    } else {
        echo $form->field($model, 'nature_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Nature::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'nature_id', 'nature_name'),
                'language' => 'th',
                'options' => ['placeholder' => '--- เลือกข้อมูล ---'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('สถานที่ธรรมชาติ');
    }

    ?>

    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>