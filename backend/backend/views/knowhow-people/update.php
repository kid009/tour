<?php

use yii\helpers\Html;

$knowhow = app\models\Knowhow::findOne($knowhow_id);

$this->title = 'แก้ไขข้อมูลบุคคลในกลุ่มองค์ความรู้ ';
$this->params['breadcrumbs'][] = ['label' => 'องค์ความรู้ (' . $knowhow->knowhow_name . ')', 'url' => ['knowhow/view', 'id' => $knowhow->knowhow_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'knowhow_id' => $knowhow_id,
            'community_id' => $knowhow->community_id,
        ]) ?>
    </div>

</div>