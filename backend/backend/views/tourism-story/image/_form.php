<?php

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin();?>

<h3>เรื่องราวจากการท่องเที่ยว : <?php echo $data->tourism_story_name ?></h3>
<hr>
<?php $form = ActiveForm::begin();?>

<?php
if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่
    echo $form->field($model, 'tourism_image_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 3000,
            ],
        ],
    ])->label(false);
} else {
    echo Html::img('@web/uploads/tourism/story/' . $model->tourism_image_file, ['style' => 'width:100px;height:100px;']);
    echo '<hr>';
    echo $form->field($model, 'tourism_image_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 3000,
            ],
        ],
    ])->label(false);
}
?>

<?php
echo $form->field($model, 'tourism_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ')
?>

<div class="pull-right">
    <?=Html::submitButton('บันทึก', ['class' => 'btn btn-success'])?>
    <a href="<?=Url::to(['tourism-story/image-index', 'id' => $id]);?>" class="btn btn-danger">
        ยกเลิก
    </a>
</div>

<?php ActiveForm::end();?>