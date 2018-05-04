<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vypln */

$this->title = Yii::t('app', 'Opravit {modelClass}', [
    'modelClass' => 'výplň',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Výplň'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="vypln-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
