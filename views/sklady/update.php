<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sklady */

$this->title = Yii::t('app', 'Opravit', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skladies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="sklady-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
