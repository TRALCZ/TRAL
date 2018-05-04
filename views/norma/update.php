<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Norma */

$this->title = Yii::t('app', 'Opravit', [
		'modelClass' => 'Norma',
	]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Norma'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="norma-update">

	<?=
	$this->render('_form', [
		'model' => $model,
	])
	?>

</div>
