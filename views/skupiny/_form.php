<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Cinnost;
use app\models\Stredisko;
/* @var $this yii\web\View */
/* @var $model app\models\Skupiny */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skupiny-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div style="float: left;" class="col-xs-12">
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	
	<div style="float: left;" class="col-xs-12">
		<?= $form->field($model, 'id_ms')->textInput(['maxlength' => true]) ?>
	</div>	

	<div class="form-group field-modely required col-xs-4">
	<?
		$zp = Cinnost::find()->all();
		$listData = ArrayHelper::map($zp, 'id', 'kod');

		echo $form->field($model, 'cinnost_id')->widget(Select2::classname(), [
			'data' => $listData,
			'options' => [
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
	
	<div class="form-group field-modely required col-xs-12"></div>
	
	<div class="form-group field-modely required col-xs-4">
	<?
		$zp = Stredisko::find()->all();
		$listData = ArrayHelper::map($zp, 'id', 'kod');

		echo $form->field($model, 'stredisko_id')->widget(Select2::classname(), [
			'data' => $listData,
			'options' => [
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

    <div class="form-group col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
