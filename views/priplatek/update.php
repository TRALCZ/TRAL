<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Priplatek */

$this->title = Yii::t('app', 'Opravit příplatek pro všechny modely');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Příplatky pro všechny modely'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="priplatek-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>