<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ผลิตภัฑณ์ธุรกิจ';
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
            <?=Html::a('<i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success'])?>
        </p>
        <hr>
        <?php if (!empty($session->getFlash('message'))): ?>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-ok"></i>
            <?php echo $session['message']; ?>
        </div>
        <?php endif;?>

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
                $url = "@web/uploads/bussiness/product/" . $data->bussiness_product_image_cover;
                return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
            },
        ], //image
        // [
        //     'attribute' => 'bussiness_product_type_id',
        //     'header' => 'ประเภทผลิตภัฑณ์ธุรกิจ',
        //     'value' => function ($model) {
        //         return $model->bussinessProductType->bussiness_product_type_name;
        //     },
        // ],
        [
            'attribute' => 'bussiness_product_group_id',
            'header' => 'กลุ่มผลิตภัฑณ์ธุรกิจ',
            'value' => function ($model) {
                return $model->bussinessProductGroup->bussiness_product_group_name;
            },
        ],
        [
            'attribute' => 'bussiness_product_name',
            'header' => 'ผลิตภัฑณ์ธุรกิจ',
            'value' => function ($model) {
                return $model->bussiness_product_name;
            },
        ],
        [
            'attribute' => 'bussiness_product_name_en',
            'header' => 'ชื่อภาษาอังกฤษ',
            'value' => function ($model) {
                return $model->bussiness_product_name_en;
            },
        ],

        [
            'attribute' => 'bussiness_product_price',
            'header' => 'ราคาผลิตภัฑณ์ธุรกิจ (บาท)',
            'value' => function ($model) {
                return $model->bussiness_product_price;
            },
        ],

        [
            'label' => 'เพิ่มภาพผลิตภัฑณ์ธุรกิจ',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'format' => 'raw',
            'value' => function ($data) {
                $url = Url::to([
                    'bussiness-image/product-index',
                    'bussiness_product_id' => $data->bussiness_product_id,
                ]);
                return Html::a('<i class="fa fa-image"></i>', $url, ['class' => 'btn btn-success']);
            },
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
                    return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->bussiness_product_id], [
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