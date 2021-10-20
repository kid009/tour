<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="user-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'community_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกชุมชน...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    ); ?>
    
    <?php echo $form->field($model, 'user_group_name')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\UserGroup::find()->all(), 'user_group_id', 'user_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือก...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    ); ?>   

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
