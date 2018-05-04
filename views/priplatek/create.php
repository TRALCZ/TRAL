<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Priplatek */

$this->title = Yii::t('app', 'Přidat příplatek pro všechny modely');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Příplatky'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="priplatek-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
