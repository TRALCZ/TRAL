<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikyCeniky */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakazniky-ceniky-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ceniky_id')->textInput() ?>

    <?= $form->field($model, 'ceniky_uuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zakazniky_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
