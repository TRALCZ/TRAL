<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\XmlImport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="xml-import-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class='form-group field-modely required col-xs-2' style="margin-top: 20px;">
		<?
			for($i = 1; $i<= 20; $i++)
			{
				$data[] = array($i => $i);
			}
			echo $form->field($model, 'kosik')->widget(Select2::classname(), [
				'data' => $data,
				'options' => [
					'value' => 12
				],
				'pluginOptions' => [
					'allowClear' => true,
				],
			]);
		?>
	</div>
	
	<div class='form-group field-modely required col-xs-12' style="margin-bottom: 0px;"></div>
	
    <div class='form-group field-modely required col-xs-4'>
		
		<?php
			echo $form->field($model, 'file')->widget(FileInput::classname(), [
				'options' => ['class' => 'col-xs-4'],
				'language' => 'cs',
				'pluginOptions' => [
					'showPreview' => false,
					'showCaption' => true,
					'showRemove' => true,
					'showUpload' => false
				],
			]);
			
		?>

	</div>
	
	<div class='form-group field-modely required col-xs-12' style="margin-bottom: 0px;"></div>

	<div class='form-group field-modely required col-xs-12'>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
