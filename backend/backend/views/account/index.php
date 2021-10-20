<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\Session;
use yii\helpers\Url;

$session = new Session();
$session->open();

$this->title = 'จัดการข้อมูลผู้ใช้';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if($session['user_login'] == 'admin'): ?>
<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

</div>
<?php endif; ?>

<?php if($session['user_login'] != 'admin'): ?>
<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">
        <?php echo $this->render('_background', ['model' => $searchModel]); ?>
    </div>

</div>
<?php endif; ?>

<div class="panel panel-default">

    <div class="panel-body">

        <?php if($session['user_login'] == 'admin'): ?>
        <p style="text-align:right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php endif; ?>
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
                        'value' => function ($data) {
                            if($data->user_image_cover != ""){
                                $url = "@web/uploads/account/" . $data->user_image_cover;
                                return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                            }
                            else{
                                $url = "@web/uploads/no_picture.jpg";
                                return Html::img($url, ['style' => 'height:100px;weidth:100px;']);
                            }
                        }
                    ],
                    [
                        'attribute' => 'user_name',
                        'header' => 'ชื่อ',
                        'value' => function ($model) {
                            return $model->user_name;
                        }
                    ],
                    [
                        'attribute' => 'user_surname',
                        'header' => 'นามสกุล',
                        'value' => function ($model) {
                            return $model->user_surname;
                        }
                    ],
                    [
                        'attribute' => 'user_telephone',
                        'header' => 'เบอร์โทรศัพท์',
                        'value' => function ($model) {
                            return $model->user_telephone;
                        }
                    ],
                    [
                        'attribute' => 'user_login',
                        'header' => 'ชื่อผู้ใช้',
                        'value' => function ($model) {
                            return $model->user_login;
                        }
                    ],
                    [
                        'attribute' => 'user_email',
                        'header' => 'อีเมล',
                        'value' => function ($model) {
                            return $model->user_email;
                        }
                    ],
                    [
                        'attribute' => 'is_active',
                        'header' => 'Active',
                        'value' => function ($model) {
                            return $model->is_active;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'แก้ไขรหัสผ่าน',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'buttonOptions' => ['class' => 'btn btn-warning'],
                        'template' => '<div style="text-align: center;"> {update} </div>',
                    ],
                    [
                        'label' => 'แก้ไขข้อมูลส่วนตัว',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $url = Url::to([
                                'account/user-detail',
                                'id' => $model->user_id,
                            ]);
                            return Html::a('<i class="fa fa-edit"></i>', $url, ['class' => 'btn btn-warning']);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'ลบข้อมูล',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'template' => '<div style="text-align: center;"> {delete} </div>',
                        'buttons' => [
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->user_id], [
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