<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;

$community = ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name');
?>

<div class="special-group-people-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <?php
        /*echo $form->field($model, 'community_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\Community::find()->all(), 'community_id', 'community_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ])->label('ชุมชน');*/
    ?>

    <?php
    /* echo '<h5><strong>ชุมชน</strong></h5>';
      echo Html::dropDownList('community', null, $community, [
      'class' => 'form-control',
      //'prompt' => 'เลือกชุมชน...',
      'id'=>'ddl-community',
      ]); */
    ?>

    <?php
    /* echo $form->field($model, 'special_group_id')->widget(DepDrop::className(), [
      'type' => DepDrop::TYPE_SELECT2,
      'options' => ['id' => 'ddl-special_group'],
      'select2Options' => [
      'pluginOptions' => ['allowClear' => true]
      ],
      'data' => [],
      'pluginOptions' => [
      'depends' => ['ddl-community'],
      //'placeholder' => 'เลือกกลุ่มอาชีพ',
      'url' => Url::to(['special-group-people/get-special'])
      ]
      ]) */
    ?>

    <?php
        echo $form->field($model, 'special_group_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\SpecialGroup::find()->all(), 'special_group_id', 'special_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]);
    ?>

    <?php
        echo $form->field($model, 'people_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(\app\models\People::find()->all(), 'people_id', 'people_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกบุคคล...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]);
    ?>

    <div class="form-group">
    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
