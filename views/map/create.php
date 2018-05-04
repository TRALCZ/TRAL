<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Map */

$this->title = Yii::t('app', 'Přidat XML-soubor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
