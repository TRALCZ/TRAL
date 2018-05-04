<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rozmer */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
    'modelClass' => 'rozměr',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rozměr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="rozmer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
