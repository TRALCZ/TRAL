<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ucty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ucty-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?
		if (Yii::$app->controller->action->id == 'create')
		{
			$suma = 0;
		}
		else
		{
			$suma = $model->suma;
		}
	?>

	<?= $form->field($model, 'suma')->textInput(['maxlength' => true, 'value' => $suma]) ?>

    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
