<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="people-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'community_id') 
    ?>

    <?php echo $form->field($model, 'province_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\Province::find()
                ->innerJoin('community', 'community.province_id = tb_province.province_id')
                ->all(), 'province_id', 'province_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือก...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('ชื่อจังหวัด'); ?>

    <?php echo $form->field($model, 'community_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกชุมชน...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('ชื่อชุมชน'); ?>

    <?php // echo $form->field($model, 'community_number_of_population') 
    ?>

    <?php // echo $form->field($model, 'community_number_of_houses') 
    ?>

    <?php // echo $form->field($model, 'community_image_cover') 
    ?>

    <?php // echo $form->field($model, 'community_detail') 
    ?>

    <?php // echo $form->field($model, 'community_career') 
    ?>

    <?php // echo $form->field($model, 'create_by') 
    ?>

    <?php // echo $form->field($model, 'create_date') 
    ?>

    <?php // echo $form->field($model, 'update_by') 
    ?>

    <?php // echo $form->field($model, 'update_date') 
    ?>

    <?php // echo $form->field($model, 'province_id') 
    ?>

    <?php // echo $form->field($model, 'amphur_id') 
    ?>

    <?php // echo $form->field($model, 'district_id') 
    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
        <?php // echo Html::resetButton('Reset', ['class' => 'btn btn-default']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>