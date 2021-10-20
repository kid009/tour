<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'เส้นทางท่องเที่ยวหลัก';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="panel panel-default" style="margin-top: 20px;">

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

                    [
                        'label' => 'รูปภาพ',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = "@web/uploads/tourism/" . $data->tourism_main_route_image;
                            return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                        }
                    ], //image
                    [
                        'attribute' => 'tourism_main_route_name',
                        'header' => 'เส้นทางท่องเที่ยวหลัก',
                        'value' => function ($model) {
                            return $model->tourism_main_route_name;
                        }
                    ],
                    [
                        'attribute' => 'tourism_main_route_name_en',
                        'header' => 'ชื่อภาษาอังกฤษ',
                        'value' => function ($model) {
                            return $model->tourism_main_route_name_en;
                        }
                    ],
                    // [
                    //     'attribute' => 'user_group_id',
                    //     'header' => 'กลุ่มผู้ใช้',
                    //     'value' => function ($model) {
                    //         return $model->user_group_id;
                    //     }
                    // ],
                    [
                        'attribute' => 'active',
                        'header' => 'Active',
                        'value' => function ($model) {
                            return $model->active;
                        }
                    ],
                    [
                        'attribute' => 'create_by',
                        'header' => 'create',
                        'value' => function ($model) {
                            return $model->create_by;
                        }
                    ],

                    /*[
                    'class' => 'yii\grid\ActionColumn',
                    'template' => Helper::filterActionColumn('{view} {update} {delete}'),
                ]*/

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'แก้ไขเส้นทางย่อย',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        //'buttonOptions' => ['class' => 'btn btn-info'],
                        'template' => '<div style="text-align: center;"> {view} </div>',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, ['class' => 'btn btn-warning']);
                            }
                        ]
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->tourism_main_route_id], [
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