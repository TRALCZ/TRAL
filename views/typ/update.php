<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Typ */

$this->title = Yii::t('app', 'Opravit {modelClass}', [
    'modelClass' => 'typ zboží',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ zboží'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="typ-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
