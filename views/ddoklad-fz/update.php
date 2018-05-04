<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdokladFz */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
		'modelClass' => 'daňový doklad',
	]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daňový doklad'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>

<div class="ddoklad-fz-update">

	<?=$this->render('_form', [
		'model' => $model,
		'fz' => $fz,
	])
	?>

</div>
