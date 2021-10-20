<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>

<div class="special-group-people-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'special_group_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\SpecialGroup::find()->where(['special_group_id' => $special_group_id,])->all(), 'special_group_id', 'special_group_name'),
        'language' => 'th',
        /*'options' => ['placeholder' => 'เลือกกลุ่ม...'],
          'pluginOptions' => [
          'allowClear' => TRUE
          ]*/
      ]
      ); ?>

    <?php echo $form->field($model, 'people_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\People::find()->where(['community_id' => $community_id])->all(), 'people_id', 'people_name'),
        'language' => 'th',
        /*'options' => [
            'placeholder' => 'เลือกบุคคล...'
        ],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]*/
      ]
      ); ?>

    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['special-group/view', 'id' => $special_group_id]); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

<?php ActiveForm::end(); ?>

</div>
