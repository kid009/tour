<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;

$session = new Session();
$session->open();

$this->title = 'ภาพองค์ความรู้';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <div class="row">

            <div class="col-md-9">
                <h3>องค์ความรู้ : <?php echo $bussiness->bussiness_knowhow_name ?></h3>
            </div>

            <div class="col-md-3" style="margin-top:20px;">
                <p style="text-align:right">

                    <a href="<?php echo Url::to(['bussiness-image/knowhow-create', 'bussiness_knowhow_id' => $bussiness_knowhow_id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
                    </a>

                    <!-- <a href="<?php //echo Url::to(['bussiness-knowhow/index']); ?>" class="btn btn-danger">
                        กลับหน้าหลัก
                    </a> -->
                </p>
            </div>

            <?php //if (!empty($session->getFlash('message'))) : ?>
                <!-- <div class="alert alert-success">
                    <i class="glyphicon glyphicon-ok"></i>
                    <?php //echo $session['message']; ?>
                </div> -->
            <?php //endif; ?>
        </div>
        <hr>
        <div class="row">
            <?php //foreach ($bussinessKnowhowImages as $values) : ?>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div>
                                <?php
                                // echo Html::img('@web/uploads/bussiness/knowhow/' . $values['bussiness_image_file'], ['style' => 'width:200px;height:200px;']) . "<br><br>";
                                // if (!empty($values['bussiness_image_name'])) {
                                    // echo $values['bussiness_image_name'];
                                // }
                                ?>
                            </div>
                            <div class="pull-right">

                                <!-- <a class="btn btn-warning" href="<?php //echo Url::to(['bussiness-image/knowhow-update', 'bussiness_knowhow_id' => $bussiness_knowhow_id, 'bussiness_image_id' => $values['bussiness_image_id']]); ?>"> -->
                                    <!-- <span class="glyphicon glyphicon-pencil"></span>
                                </a> -->

                                <!-- <a class="btn btn-danger" href="<?php //echo Url::to(['bussiness-image/knowhow-delete', 'bussiness_knowhow_id' => $bussiness_knowhow_id, 'bussiness_image_id' => $values['bussiness_image_id']]); ?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')"> -->
                                    <!-- <span class="glyphicon glyphicon-trash"></span>
                                </a> -->

                            </div>
                        </div>
                    </div>
                </div>
            <?php //endforeach; ?>
        </div>

    </div>

</div>