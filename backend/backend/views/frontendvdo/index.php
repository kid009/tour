<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ข้อมูล VDO หน้า HOME';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="panel panel-default">

    <div class="panel-body">
        <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
        <hr>
        <p>
            <a href="<?= Url::to(['frontendvdo/create']); ?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
            </a>
        </p>
        
        <?php if (!empty($session->getFlash('message'))): ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'frontend_vdo_name',
                    'header' => 'Name',
                    'value' => function($model){
                        return $model->frontend_vdo_name;
                    }
                ],
                [
                    'attribute' => 'frontend_vdo_order',
                    'header' => 'Order',
                    'value' => function($model){
                        return $model->frontend_vdo_order;
                    }
                ],        
//                [
//                    'class' => 'yii\grid\ActionColumn',
//                    'header' => 'ดูข้อมูล',
//                    'headerOptions' => ['style' => 'text-align: center;'],
//                    'buttonOptions' => ['class' => 'btn btn-info'],
//                    'template' => '<div style="text-align: center;"> {view} </div>',
//                ],
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
                            return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->frontend_vdo_id], [
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
        ]);
        ?>
</div>
    </div>
</div>
