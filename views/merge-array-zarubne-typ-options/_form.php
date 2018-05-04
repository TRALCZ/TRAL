<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\MergeArrayZarubneTyp;

/* @var $this yii\web\View */
/* @var $model app\models\TitleArrayTypOptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="merge-array-zarubne-typ-options-form">

    <?php $form = ActiveForm::begin(); ?>

    
	<?
		$ml = MergeArrayZarubneTyp::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');
	?>
	
	<div class='form-group field-modely required col-xs-4'>
		<?
			echo $form->field($model, 'merge_array_zarubne_typ_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'mergearrayzarubnetypid1',
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
	<div class='form-group field-modely required col-xs-4'>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>

	<div class='form-group field-modely required col-xs-4'>
		<?= $form->field($model, 'znac')->textInput(['maxlength' => true]) ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', id=>'btn_submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
