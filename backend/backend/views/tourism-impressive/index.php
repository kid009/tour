<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ความประทับใจการเดินทาง';
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
                $url = "@web/uploads/tourism/impressive/" . $data->tourism_impressive_image_cover;
                return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
            },
        ], //image
        [
            'attribute' => 'tourism_impressive_group_id',
            'header' => 'กลุ่มความประทับใจ',
            'value' => function ($model) {
                return $model->tourismImpressiveGroup->tourism_impressive_group_name;
            },
        ],
        [
            'attribute' => 'tourism_impressive_name',
            'header' => 'เรื่องความประทับใจ',
            'value' => function ($model) {
                return $model->tourism_impressive_name;
            },
        ],
        [
            'attribute' => 'tourism_impressive_name_en',
            'header' => 'ชื่อภาษาอังกฤษ',
            'value' => function ($model) {
                return $model->tourism_impressive_name_en;
            },
        ],
        [
            'attribute' => 'is_active',
            'header' => 'Active',
            'value' => function ($model) {
                return $model->is_active;
            },
        ],

        [
            'label' => 'เพิ่มภาพความประทับใจ',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'format' => 'raw',
            'value' => function ($data) {
                $url = Url::to([
                    'tourism-image/impressive-index',
                    'tourism_impressive_id' => $data->tourism_impressive_id,
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
                    return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->tourism_impressive_id], [
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