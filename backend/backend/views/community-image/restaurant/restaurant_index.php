<?php

use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;

$restaurant = app\models\Restaurant::find()->where(['restaurant_id' => $restaurant_id])->one();

$session = new Session();
$session->open();

$this->title = 'ภาพประเพณี';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo $restaurant->restaurant_name; ?> : <?php echo $community->community_name ?></h1>
<div class="panel panel-default">

    <div class="panel-body">

        <p>
            <a href="<?php echo Url::to(['community-image/form-restaurant', 'community_id' => $community->community_id, 'restaurant_id' => $restaurant_id]); ?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
            </a>
            <a href="<?php echo Url::to(['restaurant/index',]); ?>" class="btn btn-danger">
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
                                <?php echo Html::img('@web/uploads/community/'. $commuintyImages->community_id.'/restaurant/'. $commuintyImages->community_image_file, ['style' => 'width:200px;height:200px;']) ?>
                            </div>
                            <?php 
                                if(!empty($commuintyImages["community_image_name"])){
                                    echo $commuintyImages["community_image_name"]; 
                                }
                            ?>
                        </div>
                        
                        <div class="panel-footer text-right">
                            <a class="btn btn-warning" href="<?php echo Url::to(['community-image/form-edit-restaurant', 'community_id' => $community->community_id, 'restaurant_id' => $restaurant_id, 'image_id' => $commuintyImages->community_image_id]); ?>">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a class="btn btn-danger" href="<?= Url::to(['community-image/restaurant-delete', 'community_id' => $commuintyImages->community_image_id, 'restaurant_id' => $restaurant_id]); ?>"
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

