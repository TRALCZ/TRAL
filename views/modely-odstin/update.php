<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModelyOdstin */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Modely Odstin',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modely Odstins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="modely-odstin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
