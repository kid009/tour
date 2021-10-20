<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->knowhow_name;
$this->params['breadcrumbs'][] = ['label' => 'องค์ความรู้', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->knowhow_name, 'url' => ['view', 'id' => $model->knowhow_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <div class="row">
            <div class="col-md-10">

            </div>
            <div class="col-md-2 pull-right" style="padding-top: 20px;">
                <a class="btn btn-success pull-right" href="<?= Url::to(['knowhow/view', 'id' => $model->knowhow_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> แก้ไขกลุ่มบุคคล
                </a>
            </div>
        </div>
        <hr>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>