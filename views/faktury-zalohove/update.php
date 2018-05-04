<?php

use yii\helpers\Html;
use app\models\UserIdentity;

/* @var $this yii\web\View */
/* @var $model app\models\Faktury */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
    'modelClass' => 'zálohovou fakturu',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury zálohové'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="faktury-update">

		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	

</div>
