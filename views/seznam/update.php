<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seznam */

$this->title = 'Opravit zásobu: id = ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seznam', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Opravit';
?>
<div class="seznam-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
