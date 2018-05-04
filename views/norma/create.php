<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Norma */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Norma'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="norma-create">

	<?=
	$this->render('_form', [
		'model' => $model,
	])
	?>

</div>
