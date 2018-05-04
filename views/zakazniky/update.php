<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Zakazniky */

$this->title = 'Opravit zákazníka: ' . $model->o_name;
$this->params['breadcrumbs'][] = ['label' => 'Zákazníky', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->o_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Opravit';
?>
<div class="zakazniky-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
