<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

$tradition = app\models\Tradition::find()->where(['tradition_id' => $tradition_id])->one();

$this->title = 'ภาพประเพณี';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-heading">
        <?php echo $tradition->tradition_name; ?> : <?php echo $community->community_name ?>
    </div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?php
        if ($model->isNewRecord) { //เพิ่มข้อมูลใหม่
            echo $form->field($model, 'community_image_file')->widget(FileInput::className(), [
                'options' => [
                    'accept' => 'image/*',
                    'pluginOptions' => [
                        'showUpload' => false,
                        'maxFileSize' => 3000
                    ]
                ]
            ])->label(FALSE);
        } else {
            echo Html::img('@web/uploads/community/' . $model->community_id . '/tradition/' . $model->community_image_file, ['style' => 'width:100px;height:100px;']);
            echo '<br><br>';
            echo $form->field($model, 'community_image_file')->widget(FileInput::className(), [
                'options' => [
                    'accept' => 'image/*',
                    'pluginOptions' => [
                        'showUpload' => false,
                        'maxFileSize' => 3000
                    ]
                ]
            ])->label(FALSE);
        }
        ?>

        <?php
        /*echo $form->field($model, 'community_image_file')->widget(FileInput::className(), [
            'options' => [
                'accept' => 'image/*',
                'pluginOptions' => [
                    'showUpload' => false,
                    'maxFileSize' => 3000
                ]
            ]
        ])->label(FALSE);*/
        ?>

        <?= $form->field($model, 'community_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ') ?>

        <?= $form->field($model, 'community_image_type')->textInput()->label('Type'); ?>

        <?= $form->field($model, 'community_image_subtype')->textInput(['maxlength' => true])->label('subtype') ?>

        <div class="pull-right">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <a href="<?= Url::to(['community-image/tradition-index', 'community_id' => $community->community_id, 'tradition_id' => $tradition_id]); ?>" class="btn btn-danger">
                ยกเลิก
            </a>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>