<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FakturySeznam */

$this->title = Yii::t('app', 'Create Faktury Seznam');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-seznam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
