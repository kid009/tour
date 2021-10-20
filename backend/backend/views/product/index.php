<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ผลิตภัณฑ์';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="panel panel-default">

    <div class="panel-body" style="text-align:right">
        <p>
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
                            $url = "@web/uploads/community/" . $data->community_id . '/product/' . $data->product_image_cover;
                            return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                        }
                    ], //image
                    [
                        'attribute' => 'product_name',
                        'header' => 'ผลิตภัณฑ์',
                        'value' => function ($model) {
                            return $model->product_name;
                        }
                    ],
                    [
                        'attribute' => 'product_group_id',
                        'header' => 'กลุ่มผลิตภัณฑ์',
                        'value' => function ($model) {
                            return $model->productGroup->product_group_name;
                        }
                    ],
                    [
                        'attribute' => 'special_group_id',
                        'header' => 'กลุ่มอาชีพ',
                        'value' => function ($model) {
                            return $model->specialGroup->special_group_name;
                        }
                    ],
                    [
                        'attribute' => 'product_contact_name',
                        'header' => 'ผู้ติดต่อ',
                        'value' => function ($model) {
                            return $model->product_contact_name;
                        }
                    ],
                    [
                        'attribute' => 'product_telephone',
                        'header' => 'เบอร์โทรศัพท์',
                        'value' => function ($model) {
                            return $model->product_telephone;
                        }
                    ],
                    [
                        'label' => 'เพิ่มภาพผลิตภัณฑ์',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to([
                                'community-image/product-index',
                                'community_id' => $data->community_id,
                                'product_id' => $data->product_id,
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->product_id], [
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