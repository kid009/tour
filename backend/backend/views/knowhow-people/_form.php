<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="knowhow-people-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php echo $form->field($model, 'knowhow_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Knowhow::find()->where(['knowhow_id' => $knowhow_id,])->all(), 'knowhow_id', 'knowhow_name'),
            'language' => 'th',
            /*'options' => ['placeholder' => 'เลือกความรู้...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]*/
        ]
    ); ?>
    
    <?php echo $form->field($model, 'people_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\People::find()->where(['community_id' => $community_id])->all(), 'people_id', 'people_name'),
            'language' => 'th',
            /*'options' => ['placeholder' => 'เลือกบุคคล...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]*/
        ]
    ); ?>   

    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['knowhow/view', 'id' => $knowhow_id]); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
