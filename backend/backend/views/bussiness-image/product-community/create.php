<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'เพิ่มภาพผลิตภัณฑ์ชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'data' => $data,
            'bussiness_product_community_id' => $bussiness_product_community_id,
        ]) ?>
    </div>

</div>