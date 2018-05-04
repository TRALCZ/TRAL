<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Moneys;

/* @var $this yii\web\View */
/* @var $model app\models\Typceny */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="typceny-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Přidat') : Yii::t('app', 'Opravit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
