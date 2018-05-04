<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'zkratka')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'poznamka')->textInput(['maxlength' => true]) ?>
	<?
		if (Yii::$app->controller->action->id == 'create')
		{
			$parentId = 0;
		} 
		else
		{
			$parentId = $model->parent_id;
		}
	?>
	<div class="form-group field-attribute-parentId">
		<?= Html::label('Parent', 'parent', ['class' => 'control-label']); ?>
		<?= Html::dropdownList(
			'Category[parentId]',
			$parentId,
			Category::getTree($model->id),
			['prompt' => 'No Parent (saved as root)', 'class' => 'form-control']
		);
		?>
	</div>
	
    <?= $form->field($model, 'position')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
