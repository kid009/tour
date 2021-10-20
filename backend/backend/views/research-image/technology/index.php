<?php

use yii\helpers\Url;
use yii\web\Session;
use yii\helpers\Html;

$session = new Session();
$session->open();

$this->title = 'ภาพเทคโนโลยี';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 20px;">

    <div class="panel-body">

        <div class="row">

            <div class="col-md-9">
                <h3>เทคโนโลยี : <?php echo $technology->researcher_technology_name ?></h3>
            </div>

            <div class="col-md-3" style="margin-top:20px;">
                <p style="text-align:right">
                    <a href="<?php echo Url::to(['research-image/technology-create', 'researcher_technology_id' => $researcher_technology_id]); ?>" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล
                    </a>
                    <a href="<?php echo Url::to(['research-technology/index',]); ?>" class="btn btn-danger">
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
            <?php foreach ($researchTechnologyImages as $values) : ?>

                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div>
                                <?php
                                echo Html::img('@web/uploads/research/technology/' . $values['research_image_file'], ['style' => 'width:200px;height:200px;']) . "<br><br>";
                                if (!empty($values['research_image_name'])) {
                                    echo $values['research_image_name'];
                                }
                                ?>
                            </div>
                            <div class="pull-right">

                                <a class="btn btn-warning" href="<?php echo Url::to(['research-image/technology-update', 'researcher_technology_id' => $researcher_technology_id, 'research_image_id' => $values['research_image_id']]); ?>">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>

                                <a class="btn btn-danger" href="<?php echo Url::to(['research-image/technology-delete', 'researcher_technology_id' => $researcher_technology_id, 'research_image_id' => $values['research_image_id']]); ?>" onclick="return confirm('ต้องการลบข้อมูลหรือไม่?')">
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