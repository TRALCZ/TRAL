<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Moneys;

$this->title = 'Nastavení';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/category"><i class="fa fa-dropbox"></i> <br>Skladové skupiny</a>   
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/typ"><i class="fa fa-tags"></i> <br>Typ zboží</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/modely"><i class="fa fa-globe"></i> <br>Modely</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/rozmer"><i class="fa fa-arrows"></i> <br>Rozměry</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/odstin"><i class="fa fa-eyedropper"></i> <br>Odstíny</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/otevirani"><i class="fa fa-exchange"></i> <br>Typ otevírání dveří</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/vypln"><i class="fa fa-database"></i> <br>Výplň</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/typzamku"><i class="fa fa-lock"></i> <br>Typ zámku</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/ventilace"><i class="fa fa-sliders"></i> <br>Ventilace</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/norma"><i class="fa fa-check-square-o"></i> <br>Normy</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/zpusoby-platby"><i class="fa fa-credit-card"></i> <br>Způsoby platby</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/status"><i class="fa fa-star-half-o"></i> <br>Stavy</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/prevzit"><i class="fa fa-hand-o-right"></i> <br>Prevziti</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/zakazniky-skupina"><i class="fa fa-users"></i> <br>Skupiny zákazníků</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/klice"><i class="fa fa-key"></i> <br>Adresní klíče</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/cenova-hladina"><i class="fa fa-money"></i> <br>Cenová hladina</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/modely-odstin"><i class="fa fa-paint-brush"></i> <br>Odstín modelů</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/rada"><i class="fa fa-align-justify"></i> <br>Řady</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/druh"><i class="fa fa-sitemap"></i> <br>Druh položky</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/skupiny"><i class="fa fa-sitemap"></i> <br>Skupiny</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/cinnost"><i class="fa fa-sitemap"></i> <br>Činnost</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/stredisko"><i class="fa fa-sitemap"></i> <br>Středisko</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/typceny"><i class="fa fa-sitemap"></i> <br>Typ ceny</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/ceniky"><i class="fa fa-sitemap"></i> <br>Seznam ceníků</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/sklady"><i class="fa fa-sitemap"></i> <br>Seznam skladů</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/jednotka"><i class="fa fa-sitemap"></i> <br>Jednotka</a>
	
	<hr class="hrline">
	Příplatky<br><br>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/priplatek"><i class="fa fa-money"></i> <br>Příplatky <br>pro všechny modely</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/priplatek-options"><i class="fa fa-align-justify"></i> <br>Příplatky <br>pro všechny modely (řádky)</a><br>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/priplatek-model"><i class="fa fa-money"></i> <br>Příplatky <br>pro konkrétní model</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/priplatek-options"><i class="fa fa-align-justify"></i> <br>Příplatky <br>pro konkrétní model (řádky)</a>
	
	<hr class="hrline">
	XML Import<br><br>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/title-array-typ"><i class="fa fa-dropbox"></i> <br>Title array typ</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/title-array-typ-options"><i class="fa fa-dropbox"></i> <br>PL název -> ID</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/merge-array-typ"><i class="fa fa-dropbox"></i> <br>Merge array typ</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/merge-array-typ-options"><i class="fa fa-dropbox"></i> <br>CZ -> PL</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/merge-array-zarubne-typ"><i class="fa fa-dropbox"></i> <br>Merge array typ zarubne</a>
	<a class="btn btn-app" href="<?= Yii::getAlias('@web') ?>/merge-array-zarubne-typ-options"><i class="fa fa-dropbox"></i> <br>Zárubně CZ -> PL</a>
	
</div>
