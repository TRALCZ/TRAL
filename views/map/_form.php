<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Map */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-form">

    <?php $form = ActiveForm::begin(); ?>

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
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'sumod')->textInput(['maxlength' => true, 'value' => 0]) ?>
	</div>

    <div class='form-group field-modely required col-xs-12'>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
