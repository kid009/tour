<?php

use yii\helpers\Html;

$this->title = 'แก้ไขข้อมูล: '.$model->research_name;
$this->params['breadcrumbs'][] = ['label' => 'งานวิจัย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->research_name, 'url' => ['view', 'id' => $model->researcher_research_id]];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'research_user_bussiness_id' => $research_user_bussiness_id,
            'research_user_community_id' => $research_user_community_id,
            'research_user_tourism_id' => $research_user_tourism_id,
            'research_user_research_id' => $research_user_research_id,
        ]) ?>
    </div>

</div>