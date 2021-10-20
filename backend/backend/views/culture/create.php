<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'วัฒนธรรมชุมชน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'amphur' => [],
            'tambon' => [],
        ]) ?>
    </div>

</div>