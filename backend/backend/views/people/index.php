<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'บุคคลในชุมชน';
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
                            if ($data->people_image != "") {
                                $url = "@web/uploads/community/" . $data->community_id . '/people/' . $data->people_image;
                            } else {
                                $url = "@web/uploads/no_picture.jpg";
                            }
                            return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                        }
                    ], //image
                    // [
                    //     'attribute' => 'community_id',
                    //     'header' => 'ชื่อชุมชน',
                    //     'value' => function ($model) {
                    //         return $model->community->community_name;
                    //     }
                    // ],
                    [
                        'attribute' => 'people_group_id',
                        'header' => 'กลุ่มบุคคล',
                        'value' => function ($model) {
                            return $model->peopleGroup->people_group_name;
                        }
                    ],
                    [
                        'attribute' => 'people_name',
                        'header' => 'ชื่อบุคคล',
                        'value' => function ($model) {
                            return $model->people_name;
                        }
                    ],
                    [
                        'attribute' => 'people_telephone',
                        'header' => 'เบอร์โทรศัพท์',
                        'value' => function ($model) {
                            return $model->people_telephone;
                        }
                    ],
                    //'people_name',
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
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->people_id], [
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