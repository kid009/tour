<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ประเพณี';
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
                        'label' => 'รูปภาพ',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = "@web/uploads/community/" . $data->community_id . '/tradition/' . $data->tradition_image_cover;
                            return Html::img($url, ['style' => 'height:100px;width:100px;']);
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
                        'attribute' => 'global_tradition_id',
                        'header' => 'กลุ่มประเพณี',
                        'value' => function ($model) {
                            return $model->globalTradition->global_tradition_name;
                        }
                    ],
                    [
                        'attribute' => 'tradition_name',
                        'header' => 'ประเพณี',
                        'value' => function ($model) {
                            return $model->tradition_name;
                        }
                    ],
                    [
                        'attribute' => 'tradition_start_date',
                        'header' => 'เริ่มกิจกรรม',
                        'value' => function ($model) {
                            return date('d-m-Y', strtotime($model->tradition_start_date));
                        }
                    ],
                    [
                        'attribute' => 'tradition_end_date',
                        'header' => 'สิ้นสุดกิจกรรม',
                        'value' => function ($model) {
                            return date('d-m-Y', strtotime($model->tradition_end_date));
                        }
                    ],
                    [
                        'attribute' => 'active',
                        'header' => 'active',
                        'value' => function ($model) {
                            return $model->active;
                        }
                    ],
                    [
                        'label' => 'เพิ่มภาพประเพณี',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to([
                                'community-image/tradition-index',
                                'community_id' => $data->community_id,
                                'tradition_id' => $data->tradition_id,
                            ]);
                            return Html::a('<i class="fa fa-image"></i>', $url, ['class' => 'btn btn-success']);
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->tradition_id], [
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