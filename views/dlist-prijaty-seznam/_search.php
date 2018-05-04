<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DlistPrijatySeznamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dlist-prijaty-seznam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dlist_prijaty_id') ?>

    <?= $form->field($model, 'seznam_id') ?>

    <?= $form->field($model, 'pocet') ?>

    <?= $form->field($model, 'cena') ?>

    <?php // echo $form->field($model, 'typ_ceny') ?>

    <?php // echo $form->field($model, 'sazba_dph') ?>

    <?php // echo $form->field($model, 'sleva') ?>

    <?php // echo $form->field($model, 'celkem') ?>

    <?php // echo $form->field($model, 'celkem_dph') ?>

    <?php // echo $form->field($model, 'vcetne_dph') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
