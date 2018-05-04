<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use app\models\Zakazniky;

/* @var $this yii\web\View */
/* @var $model app\models\Rada */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rada-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class='form-group field-modely required col-xs-6'>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>	

	<?
		$ml = Zakazniky::find()->where(['zakazniky_skupina_id' => 2])->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'o_name');
	?>

	<div class='form-group field-modely required col-xs-6'>
		<?
			echo $form->field($model, 'zakazniky_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'zakazniky1',
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
	
	 <div class="form-group  col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
