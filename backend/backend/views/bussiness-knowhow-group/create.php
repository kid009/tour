<?php

use yii\helpers\Html;

$this->title = 'เพิ่มข้อมูล';
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มองค์ความรู้ธุรกิจ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?=$this->render('_form', [
    'model' => $model,
])?>
    </div>

</div>