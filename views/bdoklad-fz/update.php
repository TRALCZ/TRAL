<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdokladFz */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
		'modelClass' => 'bankovní doklad',
	]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bankovní doklad'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>

<div class="bdoklad-fz-update">

	<?=$this->render('_form', [
		'model' => $model,
		'fz' => $fz,
	])
	?>

</div>
