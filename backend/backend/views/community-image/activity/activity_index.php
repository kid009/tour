<?php

use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;

$activity = app\models\Activity::find()->where(['activity_id' => $activity_id])->one();

$session = new Session();
$session->open();

$this->title = 'ภาพกิจกรรม';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <div class="row">
            <div class="col-md-9">
                <h3><?php echo $community->community_name ?> : <?php echo $activity->activity_name; ?></h3>
            </div>
            <div class="col-md-3" style="margin-top:20px;">
                <p>
                    <a href="<?php echo Url::to(['community-image/form-activity', 'community_id' => $community->community_id, 'activity_id' => $activity_id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
                    </a>
                    <a href="<?php echo Url::to(['activity/index',]); ?>" class="btn btn-danger">
                        กลับหน้าหลัก
                    </a>
                </p>
            </div>
        </div>
        <hr>
        <?php if (!empty($session->getFlash('message'))) : ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($communityImage as $commuintyImages) : ?>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="thumbnail">
                                <?php echo Html::img('@web/uploads/community/' . $commuintyImages->community_id . '/activity/' . $commuintyImages->community_image_file, ['style' => 'width:200px;height:200px;']) ?>
                            </div>
                            <?php
                            if (!empty($commuintyImages["community_image_name"])) {
                                echo $commuintyImages["community_image_name"];
                            }
                            ?>
                        </div>

                        <div class="panel-footer text-right">
                            <a class="btn btn-warning" href="<?php echo Url::to(['community-image/form-edit-activity', 'community_id' => $community->community_id, 'activity_id' => $activity_id, 'image_id' => $commuintyImages->community_image_id]); ?>">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a class="btn btn-danger" href="<?= Url::to(['community-image/activity-delete', 'community_id' => $commuintyImages->community_image_id, 'activity_id' => $activity_id]); ?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
