<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CenovaHladina */

$this->title = Yii::t('app', 'Opravit: ', [
    'modelClass' => 'Cenová hladina',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cenová hladina'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="cenova-hladina-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
