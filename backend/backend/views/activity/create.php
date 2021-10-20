<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'กิจกรรมหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="panel panel-default">

    <div class="panel-body">
        <?=
        $this->render('_form', [
            'model' => $model,
            'amphur' => [],
            'tambon' => [],
        ])
        ?>
    </div>

</div>