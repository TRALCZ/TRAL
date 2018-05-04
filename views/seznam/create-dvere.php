<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Seznam */

$this->title = 'Přidat dveře';
$this->params['breadcrumbs'][] = ['label' => 'Seznam', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seznam-create">

	<?php $form = ActiveForm::begin(); ?>
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Norma</label>
		<? 
			$zp = \app\models\Norma::find()->all(); 
			$listData=ArrayHelper::map($zp,'zkratka','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'value' => 'CZ',
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>	
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Model</label>
		<? 
			$zp = \app\models\Modely::find()->all(); 
			$listData=ArrayHelper::map($zp,'name','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Rozměr</label>
		<? 
			$zp = \app\models\Rozmer::find()->all(); 
			$listData=ArrayHelper::map($zp,'id','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Odstín</label>
		<? 
			$zp = \app\models\Odstin::find()->all(); 
			$listData=ArrayHelper::map($zp,'id','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Typ otevírání dveří</label>
		<? 
			$zp = \app\models\Otevirani::find()->all(); 
			$listData=ArrayHelper::map($zp,'zkratka','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Výplň</label>
		<? 
			$zp = \app\models\Vypln::find()->all(); 
			$listData=ArrayHelper::map($zp,'zkratka','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'value' => '-',
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	<div class="form-group field-modely required col-xs-2">
		<label class="control-label" for="norma">Typ zámku</label>
		<? 
			$zp = \app\models\Typzamku::find()->all(); 
			$listData=ArrayHelper::map($zp,'zkratka','name');	

			echo Select2::widget([
				'name' => 'modely',
				'data' => $listData,
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	
	
	
    <div class="form-group col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
