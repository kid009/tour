<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\Session;
use yii\helpers\Url;

$session = new Session();
$session->open();

$this->title = 'ผลิตภัณฑ์ท่องเที่ยว';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); 
        ?>
    </div>
</div>

<div class="panel panel-default">

    <div class="panel-body">

        <p style="text-align:right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <hr>
        <?php if (!empty($session->getFlash('message'))): 
        ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; 
            ?>
        </div>
        <?php endif;
        ?>
        <div class="table-responsive">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'รูปภาพ',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = "@web/uploads/bussiness/product_tourism/" . $data->bussiness_product_tourism_image_cover;
                            return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                        }
                    ], //image
                    [
                        'attribute' => 'bussiness_product_tourism_group_id',
                        'header' => 'กลุ่ม',
                        'value' => function ($model) {
                            return $model->bussinessProductTourismGroup->bussiness_product_tourism_group_name;
                        }
                    ],
                    [
                        'attribute' => 'bussiness_product_tourism_name',
                        'header' => 'ผลิตภัณฑ์',
                        'value' => function ($model) {
                            return $model->bussiness_product_tourism_name;
                        },
                    ],
                    [
                        'label' => 'เพิ่มภาพผลิตภัณฑ์',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $url = Url::to([
                                'bussiness-product-tourism/image-index',
                                'id' => $data->bussiness_product_tourism_id,
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->bussiness_product_tourism_id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'ต้องการลบข้อมูลหรือไม่?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>