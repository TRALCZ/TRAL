<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PriplatekModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="priplatek-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', 'id'=>'btn_submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
