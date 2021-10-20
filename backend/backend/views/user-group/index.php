<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'กลุ่มผู้ใช้';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="panel panel-default">

    <div class="panel-body">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <hr>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php if (!empty($session->getFlash('message'))): ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'community_id',
                'header' => 'ชุมชน',
                'value' => function($model) {
                    if(empty($model->community->community_name)){
                        $community_name = '';
                        return $community_name;
                    }
                    return $model->community->community_name;
                }
            ],
            [
                'attribute' => 'user_group_name',
                'header' => 'ชื่อกลุ่ม',
                'value' => function($model) {
                    return $model->user_group_name;
                }
            ],
            [
                'attribute' => 'user_group_status',
                'header' => 'สถานะ',
                'value' => function($model) {
                    return $model->user_group_status;
                }
            ],            
            [
                'attribute' => 'enable_filter_content',
                'header' => 'Enable Filter Content',
                'value' => function($model) {
                    return $model->enable_filter_content;
                }
            ],            
            [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'ดูข้อมูล',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'buttonOptions' => ['class' => 'btn btn-info'],
                    'template' => '<div style="text-align: center;"> {view} </div>',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'แก้ไขข้อมูล',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'buttonOptions' => ['class' => 'btn btn-warning'],
                    'template' => '<div style="text-align: center;"> {update} </div>',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'ลบข้อมูล',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'template' => '<div style="text-align: center;"> {delete} </div>',
                    'buttons' => [
                        'delete' => function($url, $model, $key) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->user_group_id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                            'method' => 'post',
                                        ],
                            ]);
                        }
                    ]
                ],
        ],
    ]); ?>
</div>
</div>