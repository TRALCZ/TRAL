<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Modely;
use app\models\Odstin;

/* @var $this yii\web\View */
/* @var $model app\models\ModelyOdstin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modely-odstin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'modely_id')->textInput() ?>
	
	<?
		$ml = \app\models\Modely::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');
	?>
	
	<?
		if (Yii::$app->controller->action->id == 'create'):
	?>
	<div class='form-group field-modely required col-xs-12'>
		<?
			echo '<label class="control-label">Modely</label>';
			echo Select2::widget([
				'name' => 'arr-modely_id',
				'data' => $listData1,
				'options' => [
					'placeholder' => '...',
					'multiple' => true
				],
			]);
		?>
	</div>
	
	<?
		else:

	?>
	<div class='form-group field-modely required col-xs-12'>
	<?		
			echo $form->field($model, 'modely_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class' => 'hide'
				],
				'pluginOptions' => [
					'allowClear' => true
				],
			]);
		
		endif;
	?>
	</div>


    <?//= $form->field($model, 'odstin_id')->textInput() ?>
	
	<?
		$ol = \app\models\Odstin::find()->all();
		$listData2 = ArrayHelper::map($ol, 'id', 'name');
	?>	
	<div class='form-group field-modely required col-xs-12'>
		<?
			echo $form->field($model, 'odstin_id')->widget(Select2::classname(), [
				'data' => $listData2, //Category::getTree($model2->id),
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

	<div class='form-group field-modely required col-xs-12'>
		<?= $form->field($model, 'cena_odstin')->textInput() ?>
	</div>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
