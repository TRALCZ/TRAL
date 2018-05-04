<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FakturyZalohoveSeznam */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Faktury Zalohove Seznam',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury Zalohove Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="faktury-zalohove-seznam-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
