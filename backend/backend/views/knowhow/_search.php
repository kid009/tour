<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="knowhow-search">

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

    <?php echo $form->field($model, 'knowhow_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\KnowhowGroup::find()
                ->innerJoin('knowhow', 'knowhow.knowhow_group_id = knowhow_group.knowhow_group_id')
                ->all(), 'knowhow_group_id', 'knowhow_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่มความรู้...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มความรู้'); ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'knowhow_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Knowhow::find()->all(), 'knowhow_id', 'knowhow_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกความรู้...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อความรู้');
    } else {
        echo $form->field($model, 'knowhow_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Knowhow::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'knowhow_id', 'knowhow_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกความรู้...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อความรู้');
    }

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>