<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Mapa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-map">

<?php $form = ActiveForm::begin(); ?>
	
	<div class='form-group field-modely required col-xs-4'>
		
		<?
			echo '<label class="control-label">Upload Document</label>';
			echo FileInput::widget([
				'name' => 'file',
			]);
			
		?>
		

	</div>
		
<?php ActiveForm::end(); ?>	
	
	
    
</div>
