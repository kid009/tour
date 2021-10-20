<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="activity-sub-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php echo $form->field($model, 'activity_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Activity::find()->where(['activity_id' => $activity_id])->all(), 'activity_id', 'activity_name'),
            'language' => 'th',
            //'options' => ['placeholder' => 'เลือกกิจกรรม...'],
            /*'pluginOptions' => [
                'allowClear' => TRUE
            ]*/
        ]
    ); ?>

    <?= $form->field($model, 'activity_sub_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity_sub_name_en')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'activity_sub_order')->textInput() ?>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            รายละเอียดกิจกรรมย่อย
        </div>
        <div class="panel-body">                       
            <p>รายละเอียด</p>
            <?=
            $form->field($model, 'activity_sub_detail')->widget(CKEditor::className(), [
                'options' => ['row' => 3],
                'preset' => 'standard',
            ])->label(FALSE)
            ?>     
            
            <p>รายละเอียดภาษาอังกฤษ</p>
            <?=
            $form->field($model, 'activity_sub_detail_en')->widget(CKEditor::className(), [
                'options' => ['row' => 3],
                'preset' => 'standard',
            ])->label(FALSE)
            ?> 
        </div>
    </div>

    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['activity/view', 'id' => $activity_id]); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
