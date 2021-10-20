<?php

use yii\helpers\Html;

$this->title = 'เพิ่มข้อมูล';
$this->params['breadcrumbs'][] = ['label' => 'เส้นทางท่องเที่ยวย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">        
        
        <?php 
            echo $this->render('_form', [
                'model' => $model,
                'tourismMainRouteId' => $tourismMainRouteId
            ]); 
        ?>
    </div>

</div>