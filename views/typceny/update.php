<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Typceny */

$this->title = Yii::t('app', 'Opravit', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ ceny'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="typceny-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
