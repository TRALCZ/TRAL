<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikySkupina */

$this->title = Yii::t('app', 'Opravit {modelClass}: ', [
    'modelClass' => 'skupinu',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skupiny zákazníků'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="zakazniky-skupina-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
