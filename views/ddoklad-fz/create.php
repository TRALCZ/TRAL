<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdokladFz */

$this->title = Yii::t('app', 'Přidat daňový doklad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daňový doklad'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdoklad-fz-create">

	<?=
	$this->render('_form', [
		'model' => $model,
		'fz' => $fz,
	])
	?>

</div>
