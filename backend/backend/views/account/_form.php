<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;

$session = new Session();
$session->open();

$script = <<< JS

$(document).ready(function(){

    $("#passwordError").hide();

    var upperCase = new RegExp('[A-Z]');
    var numbers = new RegExp('[0-9]');

    $("#user-user_password").keyup(function() {
        var password = $(this).val();
        
        if(password.length >= 8 && password.match(upperCase) && password.match(numbers) && (/^[a-zA-Z0-9- ]*$/.test(password) == false)){
            $("#passwordError").hide();
        }
        else{
            $("#passwordError").show();
        }
    });
});

JS;

$this->registerJs($script);

?>

<div class="row">
    <div class="col-xs-8 col-md-offset-2">
        <?php $form = ActiveForm::begin(); ?>

        <?php
        if ($model->isNewRecord) {
            echo $form->field($model, 'user_login', ['enableAjaxValidation' => true])->label('ชื่อผู้ใช้');
        } else {
            echo $form->field($model, 'user_login')->textInput(['disabled' => true])->label('ชื่อผู้ใช้');
        }
        ?>

        <?php
        echo $form->field($model, 'user_password', ['enableAjaxValidation' => true])->passwordInput()->label('รหัสผ่าน <div id="passwordError" style="color: red;">ตัวอักษรอย่างน้อย 8 ตัว, ตัวเลข, อักษรพิมพ์ใหญ่, อักขระพิเศษ</div>');
        ?>

        <?php //echo $form->field($model, 'user_email', ['enableAjaxValidation' => true])->label('อีเมล'); ?>

        <?php
        if ($session['user_login'] == 'admin') {
            echo $form->field($modelUserRole, 'role_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(
                        \app\models\Role::find()
                            ->all(),
                        'role_id',
                        'role_name'
                    ),
                    'language' => 'th',
                    'options' => [
                        'placeholder' => 'เลือกข้อมูล...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            )->label('สิทธิ์การเข้าถึง');
        } else {
            echo $form->field($modelUserRole, 'role_id')->widget(
                Select2::className(),
                [
                    'data' => ArrayHelper::map(
                        \app\models\Role::find()
                            ->where(['role_id' => $modelUserRole->role_id])
                            ->all(),
                        'role_id',
                        'role_name'
                    ),
                    'language' => 'th',
                    'options' => [
                        'placeholder' => 'เลือกข้อมูล...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => TRUE
                    ]
                ]
            )->label('สิทธิ์การเข้าถึง');
        }
        ?>

        <div class="panel-body">
            <h4>Active</h4>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($model->isNewRecord) {
                        $model->is_active = 'N';
                        echo $form->field($model, 'is_active')->radioList([
                            'Y' => 'Y',
                            'N' => 'N'
                        ])->label(FALSE);
                    } else {
                        echo $form->field($model, 'is_active')->radioList([
                            'Y' => 'Y',
                            'N' => 'N'
                        ])->label(false);
                    }
                    ?>
                </div>

            </div>
        </div>

        <div class="pull-right">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <a href="<?= Url::to(['account/index']); ?>" class="btn btn-danger">
                ยกเลิก
            </a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>