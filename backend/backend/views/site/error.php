<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<div class="jumbotron">
    <div class="row">
        <div class="col-md-3">
            <?php echo Html::img(Url::base() . '/uploads/icon/stop.png', ['style' => 'width:200px;']); ?>
        </div>
        <div class="col-md-9">
            <h1 >
                <?= Html::encode($this->title); ?>
            </h1>
            <p class="text-danger">
                <?php
                $message = "คุณไม่มีสิทธิ์เข้าใช้งาน, กรุณาติดต่อเจ้าหน้าที่";
                echo nl2br(Html::encode($message));
                ?>
            </p>
        </div>
    </div>
</div>
