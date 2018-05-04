<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\PdokladFz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ddoklad-fz-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'faktury_zalohove_id')->hiddenInput(['value' => $fz['id']])->label(false); ?>
	<?= $form->field($model, 'cislo')->hiddenInput()->label(false); ?>

	<div class="form-group field-modely required col-xs-2">
		<div class="form-group field-seznam-popis required">
			<label class="control-label" for="seznam-popis">Číslo faktury</label>
			<input id="seznam-popis" class="form-control" name="Cislo_faktury" readonly="" maxlength="255" aria-required="true" type="text" value="<?= $fz['cislo'] ?>">
			<div class="help-block"></div>
		</div>
	</div>

	<div class="form-group field-modely required col-xs-4">
		<div class="form-group field-seznam-popis required">
			<label class="control-label" for="seznam-popis">Zákazník</label>
			<input id="seznam-popis" class="form-control" name="Zakaznik" readonly="" maxlength="255" aria-required="true" type="text" value="<?= $fz['zakaznik'] ?>">
			<div class="help-block"></div>
		</div>
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'celkem')->textInput(['value' => $fz['celkem'], 'maxlength' => true]) ?>
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'celkem_dph')->textInput(['value' => $fz['celkem_dph'], 'maxlength' => true]) ?>
	</div>
	
	
	<div class="form-group field-faktury-zalohove-vystaveno required col-xs-2">
		<?php
			if ($model->vystaveno && $model->vystaveno <> '1970-01-01')
			{
				$vystaveno = date("d.m.Y", strtotime($model->vystaveno));
			}
			else
			{
				$vystaveno = date("d.m.Y");
			}

			echo '<label class="control-label">Dat.vystavení</label>';
			echo DatePicker::widget([
				'name' => 'DdokladFz[vystaveno]',
				'value' => $vystaveno,
				'language' => 'cs',
				'template' => '{addon}{input}',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'dd.mm.yyyy',
					]
			]);
		?>
	</div>

	<?
	if (!$model->user_id)
	{
		$userId = Yii::$app->user->id;
	}

	echo $form->field($model, 'user_id')->hiddenInput(['value' => $userId])->label(false);
	?>

	<? $model->datetime_add = date('Y-m-d H:i:s'); ?>
	<?= $form->field($model, 'datetime_add')->hiddenInput()->label(false) ?>


	<div class="form-group col-xs-12">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
