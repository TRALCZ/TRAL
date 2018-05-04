<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DlistSeznam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dlist-seznam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'faktury_id')->textInput() ?>

    <?= $form->field($model, 'seznam_id')->textInput() ?>

    <?= $form->field($model, 'pocet')->textInput() ?>

    <?= $form->field($model, 'cena')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'typ_ceny')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sazba_dph')->textInput() ?>

    <?= $form->field($model, 'sleva')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'celkem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'celkem_dph')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vcetne_dph')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
