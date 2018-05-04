<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cinnost */

$this->title = Yii::t('app', 'Opravit: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cinnosts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="cinnost-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
