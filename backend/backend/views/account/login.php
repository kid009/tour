<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
use yii\web\Session;

$session = new Session();
$session->open();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>

<body>
	<?php $this->beginBody() ?>
	<div class="container">

		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">เข้าสู่ระบบเก็บข้อมูลท่องเที่ยวเมืองรอง</div>
					
					<div class="panel-body">
						<?php $form = ActiveForm::begin([
							'method' => 'post',
							'action' => ['account/login'],
						]); ?>

						<?php if (!empty($session->getFlash('message'))) : ?>
							<div class="alert alert-danger">
								!!! <?php echo $session['message']; ?>
							</div>
						<?php endif; ?>

						<?= $form->field($model, 'user_login')->label('ชื่อผู้ใช้'); ?>

						<?= $form->field($model, 'user_password')->passwordInput()->label('รหัสผ่าน'); ?>

						<div class="pull-right">
							<?= Html::submitButton('เข้าสู่ระบบ', ['class' => 'btn btn-primary']) ?>
						</div>

						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->

	</div>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>