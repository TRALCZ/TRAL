<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dlist */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
    'modelClass' => 'dodací list',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dodací listy'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>

<div class="dlist-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
