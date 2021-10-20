<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;
use yii\helpers\Url;

$session = new Session();
$session->open();

$this->title = 'ผู้ประกอบการ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-heading">

        <a class="btn btn-success pull-right" href="<?php echo Url::to(['enterpreneur/create']); ?>">
            <span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล
        </a>
    </div>

    <div class="panel-body">
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
                        'attribute' => 'entrepreneur_group_id',
                        'header' => 'กลุ่ม',
                        'value' => function ($data) {
                            return $data->entrepreneurGroup->entrepreneur_group_name;
                        }
                    ],
                    [
                        'attribute' => 'entrepreneur_name',
                        'header' => 'ชื่อ',
                        'value' => function ($data) {
                            return $data->entrepreneur_name;
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->entrepreneur_id], [
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