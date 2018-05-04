<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rada */

$this->title = Yii::t('app', 'Opravit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rada'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="rada-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
