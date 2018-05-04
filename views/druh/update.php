<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Klice */

$this->title = Yii::t('app', 'Opravit: ', [
    'modelClass' => 'Druh položky',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Druh položky'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="klice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
