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
    )->label('กลุ่มผลิตภัณฑ์ธุรกิจงานวิจัย');

?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?=Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>