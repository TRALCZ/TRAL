<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MergeArrayTypOptions */

$this->title = Yii::t('app', 'Přidat Merge Array Typ Options');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merge Array Typ Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merge-array-typ-options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
