<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ObjednavkySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objednavky-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cislo') ?>

    <?= $form->field($model, 'popis') ?>

    <?= $form->field($model, 'zpusoby_platby_id') ?>

    <?= $form->field($model, 'zakazniky_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'vystaveno') ?>

    <?php // echo $form->field($model, 'platnost') ?>

    <?php // echo $form->field($model, 'datetime_add') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'objednavka_vystavena') ?>

    <?php // echo $form->field($model, 'faktura_vydana') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
