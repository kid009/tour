<script>
    /*if (location.protocol !== 'https:')
     {
     location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
     }*/
</script>

<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\web\Session; 

$session = new Session();
$session->open();

$user = $session['user_login'];
$date = Yii::$app->formatter->asDatetime(time());
$request = Yii::$app->request->queryString;
$serverName = Yii::$app->request->serverName;

Yii::$app->db->createCommand("
INSERT INTO public.bb_user_log(
log_user, log_url, log_date, log_server_name)
VALUES ('$user', '$request', '$date', '$serverName');
")->execute();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Leaflet' -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

</head>

<body>
    <?php $this->beginBody() ?>

    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <?php require 'header_menu.php'; ?>
        </div>
    </nav>

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <?php

        require '_sidebar_menu.php';
        //require '_sidebar_menu_old.php';
        
        ?>
    </div>

    <!-- Page Content -->
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?php //Alert::widget() 
                ?>
            </ol>
        </div>
        <!--/.row-->

        <div class="container-fluid">
            <?= $content; ?>
        </div>
    </div>
    <!--/.main-->

    <?php require 'footer.php'; ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>