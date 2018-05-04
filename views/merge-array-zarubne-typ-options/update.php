<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MergeArrayZarubneTypOptions */

$this->title = Yii::t('app', 'Opravit Merge Array Zarubne Typ Options', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merge Array Zarubne Typ Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="merge-array-zarubne-typ-options-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
