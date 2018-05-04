<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'zakazka') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'postalCode') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'htmlContent') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'datetime_add') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
