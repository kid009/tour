<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->user_group_name;
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มผู้ใช้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="row">
    <div class="col-md-10">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-md-2" style="padding-top: 20px;">
        <?= Html::a('แก้ไขข้อมูล', ['update', 'id' => $model->user_group_id], ['class' => 'btn btn-warning']) ?>
        <?=
        Html::a('ลบข้อมูล', ['delete', 'id' => $model->user_group_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                'method' => 'post',
            ],
        ])
        ?>
    </div>
</div>


<div class="panel panel-default">

    <div class="panel-body">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'user_group_id',
                'user_group_name',
                'user_group_detail:ntext',
                'user_group_status',
                'community_id',
                'create_by',
                'create_date',
                'update_by',
                'update_date',
            ],
        ])
        ?>
    </div>
    
</div>
