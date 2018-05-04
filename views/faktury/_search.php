<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FakturySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faktury-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nabidky_id') ?>

    <?= $form->field($model, 'cislo') ?>

    <?= $form->field($model, 'popis') ?>

    <?= $form->field($model, 'zpusoby_platby_id') ?>

    <?php // echo $form->field($model, 'zakazniky_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'vystaveno') ?>

    <?php // echo $form->field($model, 'platnost') ?>

    <?php // echo $form->field($model, 'datetime_add') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>