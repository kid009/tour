<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->special_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มอาชีพ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->special_group_name, 'url' => ['view', 'id' => $model->special_group_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <div class="row">
            <div class="col-md-10">

            </div>
            <div class="col-md-2 pull-right" style="padding-top: 20px;">
                <a class="btn btn-success pull-right" href="<?= Url::to(['special-group/view', 'id' => $model->special_group_id]); ?>">
                    <span class="glyphicon glyphicon-plus"></span> แก้ไขกลุ่มบุคคล
                </a>
            </div>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>