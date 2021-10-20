<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: ' . $model->poi_name;
$this->params['breadcrumbs'][] = ['label' => 'สถานที่ที่เกี่ยวข้อง', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->poi_name, 'url' => ['view', 'id' => $model->poi_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">
    
    <div class="panel-body">
        <?=
        $this->render('_form', [
            'model' => $model,
            'amphur' => $amphur,
            'tambon' => $tambon,
        ])
        ?>
    </div>
</div>
