<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Slide Images';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <p style="text-align:right">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <hr>
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
                        'value' => function($data) {
                            $url = "@web/uploads/frontend/slide_image/" . $data->tourism_province_silde_image_name;
                            return Html::img($url, ['style' => 'height:150px;width:200px;',]);
                        }
                    ], //image
                    [
                        'attribute' => 'tourism_province_slide_order',
                        'header' => 'ลำดับ',
                        'value' => function($model) {
                            return $model->tourism_province_slide_order;
                        }
                    ],
                    [
                        'attribute' => 'active',
                        'header' => 'active',
                        'value' => function($model) {
                            return $model->active;
                        }
                    ],
                    
                    //'type_slide_image',
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->tourism_province_slide_image_id], [
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