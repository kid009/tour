<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="poi-search">

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

    <?php echo $form->field($model, 'poi_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\PoiGroup::find()
                ->all(), 'poi_group_id', 'poi_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'กลุ่มสถานที่...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มสถานที่ที่เกี่ยวข้อง'); ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'poi_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Poi::find()->all(), 'poi_id', 'poi_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกสถานที่...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อสถานที่ที่เกี่ยวข้อง');
    } else {
        echo $form->field($model, 'poi_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\Poi::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'poi_id', 'poi_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกสถานที่...'],
                'pluginOptions' => [
                    'allowClear' => TRUE
                ]
            ]
        )->label('ชื่อสถานที่ที่เกี่ยวข้อง');
    }

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>