<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Klice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="klice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?
		if($model->zobrazovat == "Ano")
		{
			$list = ['2'=>'Ne'];
		}
		else
		{
			$list = ['1'=>'Ano'];
		}

	?>
    <?= $form->field($model, 'zobrazovat')->dropDownList(['1'=>'Ano', '2'=>'Ne'], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
