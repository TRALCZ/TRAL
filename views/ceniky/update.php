<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ceniky */

$this->title = Yii::t('app', 'Opravit', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cenikies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="ceniky-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
