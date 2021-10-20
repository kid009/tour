<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'กิจกรรมในกลุ่มอาชีพ';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="panel panel-default">

    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <hr>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php if (!empty($session->getFlash('message'))): ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                [
                    'attribute' => 'special_group_id',
                    'value' => function($model) {
                        return $model->specialGroup->special_group_name;
                    }
                ],
                        
                [
                    'attribute' => 'activity_id',
                    'value' => function($model) {
                        return $model->activity->activity_name;
                    }
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
                        'delete' => function($url, $model, $key) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->activity_special_group_id], [
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