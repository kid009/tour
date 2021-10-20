<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

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

<?php echo $form->field($model, 'ar_url')->textInput(['maxlength' => true])->label('Link Web/Android') ?>

<?php echo $form->field($model, 'ar_url_ios')->textInput(['maxlength' => true])->label('Link IOS') ?>

<div class="panel panel-default">
    <div class="panel-heading">
        Active
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    $model->active = 'N';
                    echo $form->field($model, 'active')->radioList([
                        'Y' => 'Y',
                        'N' => 'N'
                    ])->label(FALSE);
                } else {
                    echo $form->field($model, 'active')->radioList([
                        'Y' => 'Y',
                        'N' => 'N'
                    ])->label(false);
                }
                ?>
            </div>

        </div>
    </div>
</div>

<div class="form-group" style="text-align:right">
    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    <a href="<?= Url::to(['ar/index']); ?>" class="btn btn-danger">
        ยกเลิก
    </a>
</div>

<?php ActiveForm::end(); ?>