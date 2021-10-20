<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();
?>

<div class="culture-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?php
    echo $form->field($model, 'tourism_impressive_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\TourismImpressiveGroup::find()->all(), 'tourism_impressive_group_id', 'tourism_impressive_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('กลุ่มความประทับใจการเดินทางงานวิจัย');
    ?>

    <?php
    if ($session['user_login'] == 'admin') {
        echo $form->field($model, 'tourism_impressive_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\TourismImpressive::find()->all(), 'tourism_impressive_id', 'tourism_impressive_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกความประทับใจการเดินทาง...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อความประทับใจการเดินทาง');
    } else {
        echo $form->field($model, 'tourism_impressive_id')->widget(
            Select2::className(),
            [
                'data' => ArrayHelper::map(\app\models\TourismImpressive::find()->where(['create_by' => $session['user_login']])->all(), 'tourism_impressive_id', 'tourism_impressive_name'),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกความประทับใจการเดินทาง...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]
        )->label('ชื่อความประทับใจการเดินทาง');
    }

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>