<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MergeArrayTyp */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merge Array Typ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merge-array-typ-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
