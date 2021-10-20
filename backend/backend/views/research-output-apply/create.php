<?php

$this->title = 'เพิ่มข้อมูล';
$this->params['breadcrumbs'][] = ['label' => 'การนำไปใช้ประโยชน์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'modelPathofOutputApply' => $modelPathofOutputApply,
            'amphur' => [],
            'tambon' => [],
        ]) ?>
    </div>

</div>