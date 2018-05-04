<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\file\FileInput;
use app\models\Rada;
use app\models\CenovaHladina;

/* @var $this yii\web\View */
/* @var $model app\models\Modely */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modely-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class='form-group field-modely required col-xs-12'>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	
	<?
		$ml = Rada::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');
	?>
	
	<div class='form-group field-modely required col-xs-12'>
		<?
			echo $form->field($model, 'rada_id')->widget(Select2::classname(), [
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
		?>
	</div>
	
	<div class='form-group field-modely required col-xs-12'>
		<?= $form->field($model, 'cena')->textInput(['maxlength' => true]) ?>
	</div>

	<?	
		$c_hladina = CenovaHladina::find()->all();
		foreach($c_hladina as $ch)
		{
			$c_data[] = [$ch['id'] => $ch['name']];
		}

		$c_list = Select2::widget([
			'name' => 'c-hladina',
			'value' => json_decode($model->c_hladina), // initial value
			'data' => $c_data,
			'maintainOrder' => true,
			'options' => ['placeholder' => '', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
				'maximumInputLength' => 15
			],
		]);
	?>
	
	<div class='form-group field-modely required col-xs-12'>
		<?= Html::label('Cenová hladina', 'c_hladina', ['class' => 'control-label']); ?>
		<?= $c_list ?>
	</div>
	
	
	<div class='form-group field-modely required col-xs-4'>
		
		<?
			echo $form->field($model, 'file')->widget(FileInput::classname(), [
				'options' => ['class' => 'col-xs-4'],
				'pluginOptions' => [
					'showUpload' => false,
					'browseLabel' => '',
					'removeLabel' => '',
					'mainClass' => 'input-group-lg'
				]
			]);
			
		?>
		

	</div>
	
	<div class='form-group field-modely required col-xs-12'>
		<?php
			if (isset($model->image) && ($model->image <> 'NULL'))
			{
				echo newerton\fancybox\FancyBox::widget([
					'target' => 'a[rel=fancybox]',
					'helpers' => false,
					'mouse' => true,
					'config' => [
						//'maxWidth' => '50%',
						//'maxHeight' => '800px',
						'playSpeed' => 7000,
						'padding' => 0,
						'fitToView' => false,
						//'width' => '70%',
						//'height' => '50%',
						'autoSize' => false,
						'closeClick' => false,
						'openEffect' => 'elastic',
						'closeEffect' => 'elastic',
						'prevEffect' => 'elastic',
						'nextEffect' => 'elastic',
						'closeBtn' => false,
						'openOpacity' => true,
						'helpers' => [
							'title' => ['type' => 'float'],
							'buttons' => [],
							'thumbs' => ['width' => 68, 'height' => 50],
							'overlay' => [
								'css' => [
									'background' => 'rgba(0, 0, 0, 0.8)'
								]
							]
						],
					]
				]);

				echo "<div class='form-group field-modely required col-xs-12'>";
				echo Html::a(Html::img($model->image, ['style' => 'height: 300px; border: 1px solid #3C8DBC; border-radius: 10px; padding: 10px;', 'class' => '']), $model->image, ['rel' => 'fancybox', 'title' => $model->name]);
				echo "</div>";
				echo "<div class='form-group field-modely required col-xs-12'>";
				echo $form->field($model, 'del_img')->checkBox();
				echo "</div>";
			}
		?>
	</div>

    <div class='form-group field-modely required col-xs-12'>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Uložít'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
