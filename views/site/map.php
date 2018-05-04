<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Map;
use kartik\select2\Select2;

$this->title = 'Mapa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-map">

<?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group field-modely required col-xs-2">
		<?
			$zakazka = Yii::$app->request->get('zakazka');
			/*
			if ($zakazka > 0)
			{
				
			} 
			else
			{
				$zakazka = 1;
			}
			*/
		
			$zp = Map::find()->all();
			$listData = ArrayHelper::map($zp, 'zakazka', 'zakazka');

			echo '<label class="control-label">Vyberte zakazku</label>';
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
					'allowClear' => true
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
			//'center' => center,
			'wrapperHeight' => '700px',
		],
		
	]);
	
	?>
    
</div>
