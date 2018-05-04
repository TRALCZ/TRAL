<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nabidky */

$this->title = 'Opravit nabídku: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nabidky vystavené', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Opravit';
?>
<div class="nabidky-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
