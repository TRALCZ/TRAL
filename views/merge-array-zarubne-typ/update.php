<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MergeArrayZarubneTyp */

$this->title = Yii::t('app', 'Update Merge Array Zarubne Typ: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merge Array Zarubne Typs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="merge-array-zarubne-typ-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
