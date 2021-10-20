<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->researcher_output_apply_name;
$this->params['breadcrumbs'][] = ['label' => 'ผลการนำไปใช้ประโยชน์', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->researcher_output_apply_name, 'url' => ['view', 'id' => $model->researcher_output_apply_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'modelPathofOutputApply' => $modelPathofOutputApply,
            'amphur' => $amphur,
            'tambon' => $tambon,
        ]) ?>
    </div>

</div>