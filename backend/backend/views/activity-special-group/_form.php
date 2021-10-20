<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$activity = \app\models\Activity::findOne($activity_id);
?>

<div class="activity-special-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'activity_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\Activity::find()->where(['activity_id' => $activity_id])->all(), 'activity_id', 'activity_name'),
        'language' => 'th',
            /* 'options' => ['placeholder' => 'เลือกกิจกรรม...'],
              'pluginOptions' => [
              'allowClear' => TRUE
              ] */
            ]
    );
    ?>

    <?php
    echo $form->field($model, 'special_group_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\SpecialGroup::find()->where(['community_id' => $activity->community_id])->all(), 'special_group_id', 'special_group_name'),
        'language' => 'th',
        'options' => ['placeholder' => 'เลือกสถานที่...'],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]
            ]
    );
    ?>

    <div class="pull-right">
    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['activity/view', 'id' => $activity_id]); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
