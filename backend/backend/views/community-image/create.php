<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CommunityImage */

$this->title = 'Create Community Image';
$this->params['breadcrumbs'][] = ['label' => 'Community Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="community-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
