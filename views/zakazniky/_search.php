<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakazniky-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'ico') ?>

    <?php // echo $form->field($model, 'dic') ?>

    <?php // echo $form->field($model, 'kontaktni_osoba') ?>

    <?php // echo $form->field($model, 'f_ulice') ?>

    <?php // echo $form->field($model, 'f_mesto') ?>

    <?php // echo $form->field($model, 'f_psc') ?>

    <?php // echo $form->field($model, 'f_zeme') ?>

    <?php // echo $form->field($model, 'd_ulice') ?>

    <?php // echo $form->field($model, 'd_mesto') ?>

    <?php // echo $form->field($model, 'd_psc') ?>

    <?php // echo $form->field($model, 'd_zeme') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
