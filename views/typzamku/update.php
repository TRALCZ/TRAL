<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Typzamku */

$this->title = Yii::t('app', 'Opravit {modelClass}', [
    'modelClass' => 'typ zámku',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ zámku'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="typzamku-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
