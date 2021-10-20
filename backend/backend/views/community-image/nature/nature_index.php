<?php

use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;

$nature = app\models\Nature::find()->where(['nature_id' => $nature_id])->one();

$session = new Session();
$session->open();

$this->title = 'ภาพบรรยากาศสถานที่';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <?php echo $nature->nature_name; ?> : <?php echo $community->community_name ?>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?php echo Url::to(['community-image/form-nature', 'com_id' => $community->community_id, 'nature_id' => $nature_id]); ?>" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
                </a>
                <a href="<?php echo Url::to(['nature/index',]); ?>" class="btn btn-danger">
                    กลับหน้าหลัก
                </a>
            </div>
        </div>
    </div>

    <div class="panel-body">

        <?php if (!empty($session->getFlash('message'))) : ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($commuintyImage as $commuintyImages) : ?>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="thumbnail">
                                <?php echo Html::img('@web/uploads/community/' . $commuintyImages->community_id . '/nature/' . $commuintyImages->community_image_file, ['style' => 'width:200px;height:200px;']) ?>
                            </div>
                            <?php
                            if (!empty($commuintyImages["community_image_name"])) {
                                echo $commuintyImages["community_image_name"];
                            }
                            ?>
                        </div>
                        <div class="panel-footer text-right">
                            <a class="btn btn-warning" href="<?php echo Url::to(['community-image/form-edit-nature', 'com_id' => $community->community_id, 'nature_id' => $nature_id, 'image_id' => $commuintyImages->community_image_id]); ?>">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a class="btn btn-danger" href="<?= Url::to(['community-image/nature-delete', 'com_id' => $commuintyImages->community_image_id, 'nature_id' => $nature_id]); ?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>