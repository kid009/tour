<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\Session;

$conn_string = "host=54.169.131.81 port=5432 dbname=db_tourism user=postgres password=1234";
$dbconn = pg_connect($conn_string);

?>

<style>
    @media screen and (max-width: 450px) {
        .profile {
            left: 25%;
        }
    }
</style>

<div class="activity-search">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php
    $session = new Session();
    $session->open();

    if ($session['user_login'] != 'admin') {

        $username = $session['user_login'];
        $sql = "SELECT * FROM community WHERE  update_by = '$username' ";
        $result = pg_query($dbconn, $sql);
        $row = pg_fetch_array($result);

    ?>

        <div>
            <?php if (!empty($row['community_image_background_cover'])) {
                echo Html::img('@web/uploads/community/background/' . $row['community_image_background_cover'], ['style' => 'height:400px;width:100%;border-radius: 7px;']);
            } else {
                echo Html::img('@web/uploads/backgroud_gray.jpg', ['style' => 'height:400px;width:100%;']);
            } ?>

            <?php if (!empty($row['community_image_cover'])) {
                echo Html::img(
                    '@web/uploads/community/' . $row['community_image_cover'],
                    ['style' => 'height:200px;width:200px;border-radius: 50%; top:315px;margin-bottom: -175px;border: 3px solid grey; left:40%;position:absolute; ']
                );
            } else {
                echo Html::img('@web/uploads/no_picture.jpg', ['style' => 'height:200px;width:200px;border-radius: 50%; top:315px;margin-bottom: -175px;border: 3px solid grey; left:40% ;background-color: #DCDCDC; position:absolute;']);
            } ?>
        </div>



    <?php }   ?>

    <?php ActiveForm::end(); ?>


</div>