<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DlistSeznam */

$this->title = Yii::t('app', 'Create Dlist Seznam');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dlist Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dlist-seznam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
