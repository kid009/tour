<?php

use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;

$knowhow = app\models\Knowhow::find()->where(['knowhow_id' => $knowhow_id])->one();

$session = new Session();
$session->open();

$this->title = 'ภาพองค์ความรู้';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo $knowhow->knowhow_name; ?> : <?php echo $community->community_name ?></h1>
<div class="panel panel-default">

    <div class="panel-body">

        <p>
            <a href="<?php echo Url::to(['community-image/form-knowhow', 'community_id' => $community->community_id, 'knowhow_id' => $knowhow_id]); ?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
            </a>
            <a href="<?php echo Url::to(['knowhow/index',]); ?>" class="btn btn-danger">
                กลับหน้าหลัก
            </a>
        </p>
        
        <?php if (!empty($session->getFlash('message'))): ?>
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok"></i>
                <?php echo $session['message']; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($communityImage as $commuintyImages): ?>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="thumbnail">
                                <?php echo Html::img('@web/uploads/community/'. $commuintyImages->community_id.'/knowhow/'. $commuintyImages->community_image_file, ['style' => 'width:200px;height:200px;']) ?>
                            </div>
                            <?php 
                                if(!empty($commuintyImages["community_image_name"])){
                                    echo $commuintyImages["community_image_name"]; 
                                }
                            ?>
                        </div>
                        
                        <div class="panel-footer text-right">
                            <a class="btn btn-warning" href="<?php echo Url::to(['community-image/form-edit-knowhow', 'community_id' => $community->community_id, 'knowhow_id' => $knowhow_id, 'image_id' => $commuintyImages->community_image_id]); ?>">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a class="btn btn-danger" href="<?= Url::to(['community-image/knowhow-delete', 'community_id' => $commuintyImages->community_image_id, 'knowhow_id' => $knowhow_id]); ?>"
                               onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </div>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>                       

