<?php

use yii\helpers\Html;

$specialGroup = app\models\SpecialGroup::findOne($special_group_id);

$this->title = 'เพิ่มข้อมูลบุคคลในกลุ่มอาชีพ';
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มอาชีพ (' . $specialGroup->special_group_name . ')', 'url' => ['special-group/view', 'id' => $special_group_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'special_group_id' => $special_group_id,
            'community_id' => $community_id,
        ]) ?>
    </div>

</div>