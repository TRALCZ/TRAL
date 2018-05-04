<?php

use yii\helpers\Html;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $model app\models\PdokladFz */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
    'modelClass' => 'pokladní doklad',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pokladní doklad'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="pdoklad-fz-update">
	
	<?php 
		if(Yii::$app->session->hasFlash('success'))
		{	
			echo Growl::widget([
				'type' => Growl::TYPE_SUCCESS,
				'icon' => 'glyphicon glyphicon-ok-sign',
				'body' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . Yii::$app->session->getFlash('success'),
				'showSeparator' => true,
				'delay' => 0,
				'pluginOptions' => [
					'showProgressbar' => false,
					'delay' => 2000,
					'placement' => [
						'from' => 'top',
						'align' => 'right',
					]
				]
			]);
		}
	?>
	
    <?= $this->render('_form', [
        'model' => $model, 'fz' => $fz,
    ]) ?>

</div>
