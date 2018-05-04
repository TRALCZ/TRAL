<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SkladySeznamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sklady-seznam-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uuid') ?>

    <?= $form->field($model, 'ceniky_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'cena') ?>

    <?php // echo $form->field($model, 'typceny_id') ?>

    <?php // echo $form->field($model, 'seznam_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
