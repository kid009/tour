<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="activity-special-group-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <?php
    echo $form->field($model, 'special_group_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\SpecialGroup::find()->all(), 'special_group_id', 'special_group_name'),
        'language' => 'th',
        'options' => ['placeholder' => 'เลือกสถานที่...'],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]
            ]
    );
    ?>

    <?php
    echo $form->field($model, 'activity_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\Activity::find()->all(), 'activity_id', 'activity_name'),
        'language' => 'th',
        'options' => ['placeholder' => 'เลือกกิจกรรม...'],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]
            ]
    );
    ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
