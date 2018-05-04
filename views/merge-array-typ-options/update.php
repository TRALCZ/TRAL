<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MergeArrayTypOptions */

$this->title = Yii::t('app', 'Opravit Merge Array Typ Options', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merge Array Typ Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="merge-array-typ-options-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
