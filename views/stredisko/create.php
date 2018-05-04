<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stredisko */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Středisko'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stredisko-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
