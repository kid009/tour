<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\Session;

$session = new Session();
$session->open();
?>

<div class="knowhow-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php

    echo $form->field($model, 'researcher_experience_group_id')->widget(
        Select2::className(),
        [
            'data' => ArrayHelper::map(\app\models\ResearchExperienceGroup::find()->all(), 'researcher_experience_group_id', 'researcher_experience_group_name'),
            'language' => 'th',
            'options' => ['placeholder' => 'เลือกกลุ่ม...'],
            'pluginOptions' => [
                'allowClear' => TRUE
            ]
        ]
    )->label('กลุ่มประสบการณ์');

    ?>
    <hr>
    <div class="form-group" style="text-align:right">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>