<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PriplatekModel */

$this->title = Yii::t('app', 'Přidat příplatek pro konkrétní model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Příplatky'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="priplatek-model-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
