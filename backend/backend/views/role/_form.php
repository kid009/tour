<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Operation;

//เรียกใช้ไฟล์ css
$this->registerCssFile("@web/css/form.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);
//เรียกใช้ไฟล์ js
$this->registerJsFile(
    '@web/js/form.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-xs-8 col-md-offset-2">

        <?= $form->field($model, 'role_name', ['enableAjaxValidation' => true])->textInput()->label('ชื่อสิทธิ์') ?>

        <?= $form->field($model, 'role_detail')->textInput()->label('รายละเอียด') ?>

        <?= $form->field($model, 'redirect')->textInput()->label('Redirect') ?>
        <hr>

        <?php
        if ($model->isNewRecord) {
            $model->is_active = 'N';
            echo $form->field($model, 'is_active')->radioList([
                'Y' => 'Y',
                'N' => 'N'
            ])->label('Active');
        } else {
            echo $form->field($model, 'is_active')->radioList([
                'Y' => 'Y',
                'N' => 'N'
            ])->label('Active');
        }
        ?>
        <hr>
        <div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Operation</th>
                        <th style="width: 120px;text-align:center;">Show Menu</th>
                        <!--<th style="width: 80px;text-align:center;">Craete</th>
                        <th style="width: 80px;text-align:center;">Update</th>
                        <th style="width: 80px;text-align:center;">Delete</th>  -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
                    foreach ($operations as $operation) :
                    ?>
                        <tr>
                            <td style="width: 80px;text-align:center;"><?php echo $num++; ?></td>
                            <td>
                                <?php
                                if ($operation['level'] == 1) {
                                    echo $operation['operation_name_th'];
                                } elseif ($operation['level'] == 2) {
                                    echo '<p style="text-indent: 2.0em;">' . $operation['operation_name_th'] . '</p>';
                                }
                                ?>
                            </td>
                            <td style="width: 80px;text-align:center;">
                                <?php
                                if($model->isNewRecord){
                                    echo '<input type="checkbox" name="showmenu[]" value='.$operation['operation_id'].'>';
                                }
                                else{
                                    if (in_array($operation['operation_id'], $operationIdOld)) {
                                        echo  '<input type="checkbox" name="showmenu[]" value='.$operation['operation_id'].' checked>';
                                    } 
                                    else {
                                        echo '<input type="checkbox" name="showmenu[]" value='.$operation['operation_id'].'>';
                                    }
                                }
                                
                                ?>
                            </td>
                            <!-- <td style="width: 80px;text-align:center;">
                                <input type="checkbox" name="create[]" value="" id="create">
                            </td>
                            <td style="width: 80px;text-align:center;">
                                <input type="checkbox" name="update[]" value="" id="update">
                            </td>
                            <td style="width: 80px;text-align:center;">
                                <input type="checkbox" name="delete[]" value="" id="delete"> 
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pull-right">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
            <a href="<?= Url::to(['role/index']); ?>" class="btn btn-danger">
                ยกเลิก
            </a>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>