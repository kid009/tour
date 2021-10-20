<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'สถานที่ประวัติศาสตร์';
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
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

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
                            if ($data->place_image_cover != "") {
                                $url = "@web/uploads/community/" . $data->community_id . '/place/' . $data->place_image_cover;
                            } else {
                                $url = "@web/uploads/no_picture.jpg";
                            }
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
                        'attribute' => 'place_group_id',
                        'header' => 'ชื่อกลุ่ม',
                        'value' => function ($model) {
                            return $model->placeGroup->place_group_name;
                        }
                    ],

                    [
                        'attribute' => 'place_name',
                        'header' => 'ชื่อสถานที่',
                        'value' => function ($model) {
                            return $model->place_name;
                        }
                    ],

                    [
                        'attribute' => 'active',
                        'header' => 'Active',
                        'value' => function ($model) {
                            return $model->active;
                        }
                    ],
                    //'place_name',
                    //'active',        

                    [
                        'label' => 'เพิ่มภาพบรรยากาศสถานที่',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to([
                                'community-image/place-index',
                                'com_id' => $data->community_id,
                                'place_id' => $data->place_id,
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->place_id], [
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