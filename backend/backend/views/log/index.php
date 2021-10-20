<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'LOG';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?php //echo $this->render('_search', ['model' => $searchModel]); 
        ?>
    </div>

</div> -->

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

    <div class="table-responsive">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'log_user',
                        'header' => 'User',
                        'value' => function ($model) {
                            return $model["log_user"];
                        }
                    ],
                    [
                        'attribute' => 'log_url',
                        'header' => 'URL',
                        'value' => function ($model) {
                            return $model["log_url"];
                        }
                    ],
                    [
                        'attribute' => 'log_server_name',
                        'header' => 'Server Name',
                        'value' => function ($model) {
                            return $model["log_server_name"];
                        }
                    ],
                    [
                        'attribute' => 'date',
                        'header' => 'Date',
                        'value' => function ($model) {
                            return $model["date"];
                        }
                    ],
                    [
                        'attribute' => 'time',
                        'header' => 'Time',
                        'value' => function ($model) {
                            return $model["time"];
                        }
                    ],
                    
                ],
            ]);
            ?>
        </div>

    </div>

</div>