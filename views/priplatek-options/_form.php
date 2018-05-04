<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Priplatek;

/* @var $this yii\web\View */
/* @var $model app\models\PriplatekOptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="priplatek-options-form">

    <?php $form = ActiveForm::begin(); ?>

    <?
		$ml = Priplatek::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');
	?>
	
	<div class='form-group field-modely required col-xs-3'>
		<?
			echo $form->field($model, 'priplatek_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'priplatekid1',
					//'value' => $sklady_id,
					'data-zkratka' => 'CZ',
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class' => 'hide'
				],
				'pluginOptions' => [
					'allowClear' => true
				],
			]);
		?>
	</div>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'zkratka')->textInput(['maxlength' => true]) ?>
	</div>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'cena')->textInput(['maxlength' => true]) ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', 'id' =>'btn_submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
