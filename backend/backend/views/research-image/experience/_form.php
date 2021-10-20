<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
?>

<?php $form = ActiveForm::begin(); ?>

<h3>ประสบการณ์ : <?php echo $experience->researcher_experience_name ?></h3>
<hr>
<?php $form = ActiveForm::begin(); ?>

<?php
if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่
    echo $form->field($model, 'research_image_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 3000
            ]
        ]
    ])->label(FALSE);
} else {
    echo Html::img('@web/uploads/research/experience/' . $model->research_image_file, ['style' => 'width:100px;height:100px;']);
    echo '<hr>';
    echo $form->field($model, 'research_image_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 3000
            ]
        ]
    ])->label(FALSE);
}
?>

<?php
echo $form->field($model, 'research_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ')
?>

<div class="pull-right">
    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    <a href="<?= Url::to(['research-image/experience-index', 'researcher_experience_id' => $researcher_experience_id]); ?>" class="btn btn-danger">
        ยกเลิก
    </a>
</div>

<?php ActiveForm::end(); ?>