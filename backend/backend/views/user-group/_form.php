<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="user-group-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'user_group_name')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'community_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกชุมชน...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    ); ?>

    
    
    <div class="panel panel-default">
        <div class="panel-heading">
            รายละเอียดกลุ่ม
        </div>
        <div class="panel-body">  
            <?=
            $form->field($model, 'user_group_detail')->widget(CKEditor::className(), [
                'options' => ['row' => 6],
                'preset' => 'basic',
            ])->label(FALSE)
            ?>     
        </div>
    </div>

    <?php 
        if($model->isNewRecord){
            $model->user_group_status = 'N';
        }
        
        echo $form->field($model, 'user_group_status')->radioList([
                'Y' => 'Yes', 
                'N' => 'No'
            ]); 
    ?>
    <hr>
    
    <?php 
        if($model->isNewRecord){
            $model->enable_filter_content = 'N';
        }
        
        echo $form->field($model, 'enable_filter_content')->radioList([
                'Y' => 'Yes', 
                'N' => 'No'
        ]); 
    ?>
    <hr>
    
    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary']) ?>
        <a href="<?= Url::to(['user-group/index']); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
