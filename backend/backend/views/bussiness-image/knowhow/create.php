<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เพิ่มภาพองค์ความรู้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?=$this->render('_form', [
    'model' => $model,
    'knowhow' => $knowhow,
    'bussiness_knowhow_id' => $bussiness_knowhow_id,
])?>
    </div>

</div>