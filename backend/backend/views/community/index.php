<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ชุมชน';
$this->params['breadcrumbs'][] = $this->title;
//echo 'username: '.$username;
?>


<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?php echo $this->render('_background', ['model' => $searchModel]); ?>
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
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'รูปภาพชุมชน',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->community_image_cover != "") {
                                $url = "@web/uploads/community/" . $data->community_image_cover;
                            } else {
                                $url = "@web/uploads/no_picture.jpg";
                            }
                            return Html::img($url, ['style' => 'height:100px;weidth:auto;']);
                        }
                    ], //image
                    [
                        'attribute' => 'community_name',
                        'header' => 'ชื่อชุมชน',
                        'value' => function ($data) {
                            return $data->community_name;
                        }
                    ],
                    [
                        'attribute' => 'community_name_en',
                        'header' => 'ชื่อชุมชนภาษาอังกฤษ',
                        'value' => function ($data) {
                            return $data->community_name_en;
                        }
                    ],
                    [
                        'attribute' => 'active',
                        'header' => 'Active',
                        'value' => function ($data) {
                            return $data->active;
                        }
                    ],
                    //'update_by',
                    [
                        'label' => 'เพิ่มภาพบรรยากาศชุมชน',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to(['community-image/index', 'id' => $data->community_id]);
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->community_id], [
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