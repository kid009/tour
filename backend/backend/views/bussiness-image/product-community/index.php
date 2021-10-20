<?php

use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;

$session = new Session();
$session->open();

$this->title = 'ภาพผลิตภัณฑ์ชุมชน';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <div class="row">

            <div class="col-md-9">
                <h3>ผลิตภัณฑ์ชุมชน : <?php echo $data->bussiness_product_community_name ?></h3>
            </div>

            <div class="col-md-3" style="margin-top:20px;">
                <p style="text-align:right">
                    <a href="<?php echo Url::to(['bussiness-image/product-community-create', 'bussiness_product_community_id' => $bussiness_product_community_id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
                    </a>
                    <a href="<?php echo Url::to(['bussiness-product-community/index',]); ?>" class="btn btn-danger">
                        กลับหน้าหลัก
                    </a>
                </p>

            </div>

        </div>
        <?php if (!empty($session->getFlash('message'))) : ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>
        <hr>
        <div class="row">
            <?php foreach ($images as $values) : ?>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div>
                                <?php
                                echo Html::img('@web/uploads/bussiness/product_community/' . $values['bussiness_image_file'], ['style' => 'width:200px;height:200px;']) . "<br><br>";
                                if (!empty($values['bussiness_image_name'])) {
                                    echo $values['bussiness_image_name'];
                                }
                                ?>
                            </div>
                            <div class="pull-right">

                                <a class="btn btn-warning" href="<?php echo Url::to([
                                    'bussiness-image/product-community-update', 
                                    'bussiness_product_community_id' => $bussiness_product_community_id, 
                                    'bussiness_image_id' => $values['bussiness_image_id']
                                ]); ?>">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>

                                <a class="btn btn-danger" href="<?php echo Url::to([
                                    'bussiness-image/product-community-delete', 
                                    'bussiness_product_community_id' => $bussiness_product_community_id, 
                                    'bussiness_image_id' => $values['bussiness_image_id']
                                ]); ?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</div>