<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Map;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Map */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-view">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group field-modely required col-xs-2">
		<?
			$zakazka = Yii::$app->request->get('id');

			$zp = Map::find()->all();
			$listData = ArrayHelper::map($zp, 'zakazka', 'sumod');

			echo '<label class="control-label">Vyberte častku</label>';
			echo Select2::widget([
				'name' => 'zakazka',
				'data' => $listData,
				'value' => $zakazka,
				'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class' => 'hide',
					'value' => $zakazka
				],
				'pluginOptions' => [
					'allowClear' => false
				],
]);
		
		?>
		
	</div>
		
	<div class="form-group field-modely required col-xs-8" style="margin-top: 24px;">
		<? echo Html::submitButton('Vybrat', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', id=>'btn_submit']); ?>
	</div>
	
<?php ActiveForm::end(); ?>
	
	
	<?php
	
	echo yii2mod\google\maps\markers\GoogleMaps::widget([
		'userLocations' => $maps,
		'googleMapsUrlOptions' => [
			'key' => 'AIzaSyCp6eSjzd7wY8qNPNhXAMoeQunDM4j2qos',
			'language' => 'cs',
			'version' => '3.1.18',
		],
		'googleMapsOptions' => [
			'mapTypeId' => 'roadmap',
			'tilt' => 45,
			'zoom' => 15,
			'center' => 0,
			'wrapperHeight' => '700px',
		],
		
	]);
	
	?>
	

</div>
