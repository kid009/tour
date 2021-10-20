<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'กลุ่มกิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>