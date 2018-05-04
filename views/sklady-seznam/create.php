<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SkladySeznam */

$this->title = Yii::t('app', 'Seznam skladů');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sklady Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Přidat';
?>
<div class="sklady-seznam-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
