<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();
?>

<div class="product-group-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>

    <?php
if ($session['user_login'] == 'admin') {
    echo $form->field($model, 'bussiness_product_type_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\BussinessProductType::find()->all(), 'bussiness_product_type_id', 'bussiness_product_type_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('ประเภทผลิตภัณฑ์ธุรกิจงานวิจัย');
} else {
    echo $form->field($model, 'bussiness_product_type_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\BussinessProductType::find()->where(['create_by' => $session['user_login']])->all(), 'bussiness_product_type_id', 'bussiness_product_type_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('ประเภทผลิตภัณฑ์ธุรกิจงานวิจัย');
}
?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?=Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>