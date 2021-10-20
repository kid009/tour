<?php

use yii\web\Session; 
$session = new Session();
$session->open();

$request = Yii::$app->request->serverName;
//echo $request;
?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <a class="navbar-brand" href="#">
        ระบบเก็บข้อมูลท่องเที่ยวเมืองรอง
    </a>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="btn btn-info" href="#" style="width: 100%;">
                <em class="fa fa-user"></em> <?php echo $session['user_login']; ?>
            </a>
        </li>
        <li class="dropdown">
            <a class="btn btn-warning" href="http://54.169.131.81/sprintvillagear/" style="width: 100%;">
            กลับหน้าแรก
            </a>
        </li>
    </ul>
</div>