<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

$homestay = app\models\Homestay::find()->where(['homestay_id' => $homestay_id])->one();
?>
<h1><?php echo $homestay->homestay_name; ?> : <?php echo $community->community_name ?></h1>
<div class="panel panel-default">  

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
            echo Html::img('@web/uploads/community/' . $model->community_id . '/homestay/' . $model->community_image_file, ['style' => 'width:100px;height:100px;']);
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
        /* echo $form->field($model, 'community_image_file')->widget(FileInput::className(), [
          'options' => [
          'accept' => 'image/*',
          'pluginOptions' => [
          'showUpload' => false,
          'maxFileSize' => 3000
          ]
          ]
          ])->label(FALSE); */
        ?>

        <?= $form->field($model, 'community_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ') ?>

        <?= $form->field($model, 'community_image_type')->textInput()->label('Type'); ?>

        <?= $form->field($model, 'community_image_subtype')->textInput(['maxlength' => true])->label('subtype') ?>

        <div class="form-group">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary']) ?>
            <a href="<?= Url::to(['community-image/homestay-index', 'commnity_id' => $community->community_id, 'homestay_id' => $homestay_id]); ?>" class="btn btn-danger">
                ยกเลิก
            </a>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>