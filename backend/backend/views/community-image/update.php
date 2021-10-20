<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommunityImage */

$this->title = 'Update Community Image: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Community Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->community_image_id, 'url' => ['view', 'id' => $model->community_image_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="community-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
