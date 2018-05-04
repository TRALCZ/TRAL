<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MergeArrayZarubneTypOptions */

$this->title = Yii::t('app', 'Přidat Merge Array Zarubne Typ Options');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merge Array Zarubne Typ Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merge-array-zarubne-typ-options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
