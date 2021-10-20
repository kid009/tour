<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

$activity = app\models\Activity::find()->where(['activity_id' => $activity_id])->one();
echo $model->community_image_file;
?>
<h1><?php //echo $activity->activity_name; ?> : <?php //echo $community->community_name ?></h1>
<div class="panel panel-default">  

    <div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'community_image_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 3000
            ]
        ]
    ])->label(FALSE);
    ?>

    <?= $form->field($model, 'community_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ') ?>

    <?= $form->field($model, 'community_image_type')->textInput()->label('Type'); ?>

    <?= $form->field($model, 'community_image_subtype')->textInput(['maxlength' => true])->label('subtype') ?>

    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary']) ?>
        <a href="<?= Url::to(['community-image/culture-index', 'com_id' => $community->community_id, 'activity_id' => $activity_id]); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>