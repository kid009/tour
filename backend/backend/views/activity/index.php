<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'กิจกรรมหลัก';
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

                    [
                        'label' => 'รูปภาพกิจกรรม',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = "@web/uploads/community/" . $data->community_id . '/activity/' . $data->activity_image_cover;
                            return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                        }
                    ], //image

                    [
                        'attribute' => 'community_id',
                        'header' => 'ชุมชน',
                        'value' => function ($model) {
                            return $model->community->community_name;
                        }
                    ],

                    [
                        'attribute' => 'activity_group_id',
                        'header' => 'ชื่อกลุ่ม',
                        'value' => function ($model) {
                            return $model->activityGroup->activity_group_name;
                        }
                    ],

                    [
                        'attribute' => 'activity_name',
                        'header' => 'กิจกรรม',
                        'value' => function ($model) {
                            return $model->activity_name;
                        }
                    ],

                    /*[
                    //'attribute' => 'activity_name',
                    'header' => 'กิจกรรม',
                    'value' => function($model) {
                        return $model->activity_place->activity_place_id;
                    }
                ],*/

                    [
                        'label' => 'เพิ่มภาพกิจกรรม',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to([
                                'community-image/activity-index',
                                'community_id' => $data->community_id,
                                'activity_id' => $data->activity_id,
                            ]);
                            return Html::a('<i class="fa fa-image"></i>', $url, ['class' => 'btn btn-success']);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'แก้ไขกิจกรรมย่อย',
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->activity_id], [
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