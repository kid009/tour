<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Session;
use yii\widgets\ActiveForm;

$session = new Session();
$session->open();
?>

<div class="culture-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>


    <?php
    echo $form->field($model, 'bussiness_product_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\BussinessproductGroup::find()->all(), 'bussiness_product_group_id', 'bussiness_product_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('กลุ่มผลิตภัฑณ์ธุรกิจ');
?>

    <?php
if ($session['user_login'] == 'admin') {
    echo $form->field($model, 'bussiness_product_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\bussinessproduct::find()->all(), 'bussiness_product_id', 'bussiness_product_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกผลิตภัฑณ์ธุรกิจ...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('ชื่อผลิตภัฑณ์ธุรกิจ');
} else {
    echo $form->field($model, 'bussiness_product_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\bussinessproduct::find()->where(['create_by' => $session['user_login']])->all(), 'bussiness_product_id', 'bussiness_product_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกผลิตภัฑณ์ธุรกิจ...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]
    )->label('ชื่อผลิตภัฑณ์ธุรกิจ');
}

?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?=Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>