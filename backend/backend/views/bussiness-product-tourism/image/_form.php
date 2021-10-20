<?php

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin();?>

<h3>ผลิตภัณฑ์ท่องเที่ยว : <?php echo $data->bussiness_product_tourism_name ?></h3>
<hr>
<?php $form = ActiveForm::begin();?>

<?php
if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่
    echo $form->field($model, 'bussiness_image_file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'pluginOptions' => [
                'showUpload' => false,
                'maxFileSize' => 3000,
            ],
        ],
    ])->label(false);
} else {
    echo Html::img('@web/uploads/bussiness/product_tourism/' . $model->bussiness_image_file, ['style' => 'width:100px;height:100px;']);
    echo '<hr>';
    echo $form->field($model, 'bussiness_image_file')->widget(FileInput::className(), [
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
echo $form->field($model, 'bussiness_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ')
?>

<div class="pull-right">
    <?=Html::submitButton('บันทึก', ['class' => 'btn btn-success'])?>
    <a href="<?=Url::to(['bussiness-product-tourism/image-index', 'id' => $id]);?>" class="btn btn-danger">
        ยกเลิก
    </a>
</div>

<?php ActiveForm::end();?>