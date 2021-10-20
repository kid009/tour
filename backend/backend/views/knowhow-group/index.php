<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'กลุ่มความรู้';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>
<div class="panel panel-default">

    <div class="panel-body">
        <p style="text-align:right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <hr>
        <?php if (!empty($session->getFlash('message'))) : ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'knowhow_group_name',

                    [
                        'attribute' => 'knowhow_group_name',
                        'header' => 'ชื่อกลุ่ม',
                        'value' => function ($model) {
                            return $model->knowhow_group_name;
                        }
                    ],
                    [
                        'attribute' => 'knowhow_group_name_en',
                        'header' => 'ชื่อกลุ่มภาษาอังกฤษ',
                        'value' => function ($model) {
                            return $model->knowhow_group_name_en;
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
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->knowhow_group_id], [
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