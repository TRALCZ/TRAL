<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ZpusobyPlatby */

$this->title = 'Opravit způsob platby: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zpusob platby', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Opravit';
?>
<div class="zpusoby-platby-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
