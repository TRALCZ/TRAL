<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ventilace */

$this->title = Yii::t('app', 'Opravit {modelClass}', [
    'modelClass' => 'ventilace',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ventilace'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="ventilace-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
