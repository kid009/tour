<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$session = new Session();
$session->open();

$this->title = 'การนำไปใช้ประโยชน์';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
        <?= Html::beginForm(['research-output-apply/index'], 'post') ?>
        <?php
        echo '<label class="control-label">กลุ่มการนำไปใช้ประโยชน์</label>';
        echo Select2::widget([
            'name' => 'output_apply_group_id',
            'data' => ArrayHelper::map(\app\models\ResearchOutputApplyGroup::find()->all(), 'researcher_output_apply_group_id', 'researcher_output_apply_group_name'),
            'options' => [
                'placeholder' => 'เลือกกลุ่ม...',
                //'multiple' => true
            ],
        ]). "<br>";

        echo '<label class="control-label">ผลิตภัณฑ์ท่องเที่ยว</label>';
        if ($session['user_login'] == 'admin') {
            echo Select2::widget([
                'name' => 'tourism_product_id',
                'data' => ArrayHelper::map(\app\models\ResearchTourismProduct::find()->all(), 'researcher_tourism_product_id', 'researcher_tourism_product_name'),
                'options' => [
                    'placeholder' => 'เลือกกลุ่ม...',
                    //'multiple' => true
                ],
            ]) . "<br>";
        } else {
            echo Select2::widget([
                'name' => 'tourism_product_id',
                'data' => ArrayHelper::map(\app\models\ResearchTourismProduct::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'researcher_tourism_product_id', 'researcher_tourism_product_name'),
                'options' => [
                    'placeholder' => 'เลือกกลุ่ม...',
                    //'multiple' => true
                ],
            ]) . "<br>";
        }

        echo '<label class="control-label">นวัตกรรม</label>';
        if ($session['user_login'] == 'admin') {
            echo Select2::widget([
                'name' => 'innovation_id',
                'data' => ArrayHelper::map(\app\models\ResearchInnovation::find()->all(), 'researcher_innovation_id', 'researcher_innovation_name'),
                'options' => [
                    'placeholder' => 'เลือกกลุ่ม...',
                    //'multiple' => true
                ],
            ]) . "<br>";
        } else {
            echo Select2::widget([
                'name' => 'innovation_id',
                'data' => ArrayHelper::map(\app\models\ResearchInnovation::find()
                    ->where(['create_by' => $session['user_login']])
                    ->all(), 'researcher_innovation_id', 'researcher_innovation_name'),
                'options' => [
                    'placeholder' => 'เลือกกลุ่ม...',
                    //'multiple' => true
                ],
            ]) . "<br>";
        }
        ?>
        <hr>
        <div class="form-group" style="text-align:right">
            <?php echo Html::submitButton('<span class="glyphicon glyphicon-search"></span> ค้นหา', ['class' => 'btn btn-primary']) ?>
        </div>
        <?= Html::endForm() ?>
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
                        'label' => 'รูปภาพ',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $url = "@web/uploads/research/outputApply/" . $model['researcher_output_apply_image_cover'];
                            return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                        },
                    ], //image
                    [
                        'attribute' => 'researcher_output_apply_group_name',
                        'header' => 'ชื่อกลุ่ม',
                        'value' => function ($model) {
                            return $model['researcher_output_apply_group_name'];
                        }
                    ],
                    [
                        'attribute' => 'researcher_output_apply_name',
                        'header' => 'ชื่อ',
                        'value' => function ($model) {
                            return $model['researcher_output_apply_name'];
                        }
                    ],
                    [
                        'attribute' => 'researcher_tourism_product_name',
                        'header' => 'ผลิตภัณฑ์',
                        'value' => function ($model) {
                            return $model['researcher_tourism_product_name'];
                        }
                    ],
                    [
                        'attribute' => 'researcher_innovation_name',
                        'header' => 'นวัตกรรม',
                        'value' => function ($model) {
                            return $model['researcher_innovation_name'];
                        }
                    ],
                    [
                        'label' => 'เพิ่มภาพการนำไปใช้ประโยชน์',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $url = Url::to([
                                'research-image/output-apply-index',
                                'id' => $model["researcher_output_apply_id"],
                            ]);
                            return Html::a('<i class="fa fa-image"></i>', $url, ['class' => 'btn btn-success']);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'แก้ไขข้อมูล',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        //'buttonOptions' => ['class' => 'btn btn-warning'],
                        'template' => '<div style="text-align: center;"> {update} </div>',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['update', 'id' => $model["researcher_output_apply_id"]], [
                                    'class' => 'btn btn-warning',
                                ]);
                            }
                        ]
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'ลบข้อมูล',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'template' => '<div style="text-align: center;"> {delete} </div>',
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model['researcher_output_apply_id']], [
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