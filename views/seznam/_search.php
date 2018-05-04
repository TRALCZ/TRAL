<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SeznamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seznam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
		'option' => ['data-pjax'=>1]
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'popis') ?>

    <?= $form->field($model, 'plu') ?>

    <?= $form->field($model, 'stav') ?>

    <?= $form->field($model, 'rezerva') ?>

    <?php // echo $form->field($model, 'objednano') ?>

    <?php // echo $form->field($model, 'predpoklad_stav') ?>

    <?php // echo $form->field($model, 'cena_bez_dph') ?>

    <?php // echo $form->field($model, 'min_limit') ?>

    <?php // echo $form->field($model, 'cena_s_dph') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
