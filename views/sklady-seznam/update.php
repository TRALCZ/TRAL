<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SkladySeznam */

$this->title = Yii::t('app', 'Opravit', [
    'nameAttribute' => '',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seznam skladů'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="sklady-seznam-update">

     <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
