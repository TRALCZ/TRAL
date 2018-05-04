<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Otevirani */

$this->title = Yii::t('app', 'Opravit {modelClass}', [
    'modelClass' => 'typ otevírání dveří',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ otevírání dveří'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="otevirani-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
