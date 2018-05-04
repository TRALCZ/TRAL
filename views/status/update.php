<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Status */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
    'modelClass' => 'status',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
