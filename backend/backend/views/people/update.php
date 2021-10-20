<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->people_name;
$this->params['breadcrumbs'][] = ['label' => 'บุคคล', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->people_name, 'url' => ['view', 'id' => $model->people_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'amphur' => $amphur,
            'tambon' => $tambon,
        ]) ?>
    </div>
    
</div>