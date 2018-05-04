<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Objednavky */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objednavky-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cislo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'popis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zpusoby_platby_id')->textInput() ?>

    <?= $form->field($model, 'zakazniky_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'vystaveno')->textInput() ?>

    <?= $form->field($model, 'platnost')->textInput() ?>

    <?= $form->field($model, 'datetime_add')->textInput() ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'objednavka_vystavena')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'faktura_vydana')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
