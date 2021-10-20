<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\Session;

$conn_string = "host=54.169.131.81 port=5432 dbname=db_tourism user=postgres password=1234";
$dbconn = pg_connect($conn_string);

?>

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
        $sql = "SELECT * FROM bb_user WHERE  user_login = '$username' ";
        $result = pg_query($dbconn, $sql);
        $row = pg_fetch_array($result);

    ?>

        <div>
            <?php if (!empty($row['user_image_background_cover'])) {
                echo Html::img('@web/uploads/background/' . $row['user_image_background_cover'], ['style' => 'height:400px;width:100%;border-radius: 7px;']);
            } else {
                echo Html::img('@web/uploads/background/' . $row['user_image_background_cover'], ['style' => 'height:400px;width:100%; background-color: #DCDCDC; ']);
            } ?>

            <?php if (!empty($row['user_image_background_cover'])) {
                echo Html::img('@web/uploads/account/' . $row['user_image_cover'], ['style' => 'height:200px;width:200px;border-radius: 50%; top:-150px;margin-bottom: -175px;border: 3px solid grey; left:40%;position:relative;']);
            } else {
                echo Html::img('@web/uploads/no_picture.jpg', ['style' => 'height:200px;width:200px;border-radius: 50%;position:relative;top:-150px;margin-bottom: -175px;border: 3px solid grey; left:40% ;background-color: #DCDCDC;']);
            } ?>
        </div>

    <?php }   ?>

    <?php ActiveForm::end(); ?>

</div>