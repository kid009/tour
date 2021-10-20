<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\Session;

$session = new Session();
$session->open();

$user = $session['user_login'];
$data = Yii::$app->db->createCommand("select community_id from community where create_by = '$user' ")->queryAll();
$community_id = $data[0]['community_id'];

$sql = Yii::$app->db->createCommand(
        "
        select activity_id as id, CONCAT(activity_name,' (',community_name, ', ', province_name,')') as name 
        from activity
        inner join community on community.community_id = activity.community_id
        inner join tb_province on tb_province.province_id = community.province_id
        where community.community_id = $community_id
        order by community.community_id, community.province_id asc
        ")->queryAll();

$data = ArrayHelper::map($sql, 'id', 'name');

$num = Yii::$app->db->createCommand("
select max(tourism_sub_route_activity_order)
from tourism_sub_route_activity
where tourism_sub_route_id = $tourism_sub_route_id    
")->queryOne();
?>

<div class="tourism-sub-route-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'tourism_sub_route_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(\app\models\TourismSubRoute::find()->where(['tourism_sub_route_id' => $tourism_sub_route_id,])->all(), 'tourism_sub_route_id', 'tourism_sub_route_name'),
        'language' => 'th',
            /* 'options' => ['placeholder' => 'เลือก...'],
              'pluginOptions' => [
              'allowClear' => TRUE
              ] */
            ]
    );
    ?>
    
    <?php
    echo $form->field($model, 'activity_id')->widget(Select2::className(), [
        'data' => $data,
        'language' => 'th',
        'options' => ['placeholder' => 'เลือก...'],
        'pluginOptions' => [
            'allowClear' => TRUE
        ]
            ]
    );
    ?>
    
    <?php 
        if($model->isNewRecord){
            foreach($num as $nums){
                echo $form->field($model, 'tourism_sub_route_activity_order')->textInput(['value' => $nums + 1]); 
            }
        }
        else{
            echo $form->field($model, 'tourism_sub_route_activity_order')->textInput(); 
        }
    ?>

    <div class="pull-right">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['tourism-sub-route/view', 'id' => $tourism_sub_route_id]); ?>" class="btn btn-danger">
            ยกเลิก
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
