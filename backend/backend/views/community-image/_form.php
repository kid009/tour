<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
?>

<div class="panel panel-default" style="margin-top:20px;">

    <div class="panel-body">

        <h3>เพิ่มข้อมูลภาพชุมชน: <?= $community->community_name; ?></h3>
        <hr>
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
            echo Html::img('@web/uploads/community/' . $model->community_id . '/' . $model->community_image_file, ['style' => 'width:100px;height:100px;']);
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
        echo $form->field($model, 'community_image_name')->textInput(['maxlength' => true])->label('คำบรรยายใต้ภาพ')
        ?>

        <?php
        echo $form->field($model, 'community_image_type')->textInput();
        ?>

        <?= $form->field($model, 'community_image_subtype')->textInput(['maxlength' => true])->label('subtype') ?>

        <div class="pull-right">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <a href="<?= Url::to(['community-image/index', 'id' => $community->community_id]); ?>" class="btn btn-danger">
                ยกเลิก
            </a>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>