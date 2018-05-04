<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modely */

$this->title = Yii::t('app', 'Opravit', [
    'modelClass' => 'Modely',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="modely-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
