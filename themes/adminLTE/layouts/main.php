<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\themes\adminLTE\assets\AdminlteAsset;

/* @var $this \yii\web\View */
/* @var $content string */
AdminlteAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>


	</head>
	<body class="skin-blue sidebar-mini sidebar-collapse">

<?php $this->beginBody() ?>
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="/" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>T</b><!--RKADO--></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>TRAL</b></span>
				</a>

				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div style="float: left; margin-top: 5px; margin-left: 50px; color: #fff;">
					<!--	
						<a href="/nabidky" title="Nabidky vystavené" class="nav navbar-nav">
							<span class="fa-stack fa-lg"><i class="fa fa-shopping-basket fa-stack fa-inverse"></i></span>
						</a>
						<a href="/objednavky" title="Objednávky vystavené" style="margin-left: 20px;" class="header-link">
							<span class="fa-stack fa-lg"><i class="fa fa-cart-plus fa-stack fa-inverse"></i></span>
						</a>
					-->	
						<a href="/map" title="Mapa" style="margin-left: 20px;" class="header-link">
							<span class="fa-stack fa-lg"><i class="fa fa-cart-plus fa-map-o fa-inverse"></i></span>
						</a>
						<a href="/xml-import" title="XML import" style="margin-left: 20px;" class="header-link">
							<span class="fa-stack fa-lg"><i class="fa fa-file-code-o fa-file-code-o fa-inverse"></i></span>
						</a>
					</div>
					<div class="navbar-custom-menu">

						<?php
						echo Nav::widget([
							'options' => ['class' => 'nav navbar-nav'],
							'items' => [
								Yii::$app->user->isGuest ?
									['label' => 'Login', 'url' => ['/site/login']] :
									['label' => 'Logout (' . Yii::$app->user->identity->name . ')',
									'url' => ['/site/logout'],
									'linkOptions' => ['data-method' => 'post']],
							],
						]);
						?>
					</div>
				</nav>

			</header>

<?= $content ?>

			<footer class="main-footer">
				<div class="pull-right hidden-xs">
<?php echo Yii::powered(); ?>
				</div>
				Copyright &copy; <?php echo date('Y'); ?> by ERKADO CZ. All Rights Reserved.
			</footer>

		</div>

<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>
