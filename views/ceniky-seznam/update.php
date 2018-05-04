<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CenikySeznam */

$this->title = Yii::t('app', 'Opravit', []);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seznam ceníků'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Opravit');
?>
<div class="ceniky-seznam-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
