<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CenovaHladina */

$this->title = Yii::t('app', 'Cenová hladina');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cenová hladina'), 'url' => ['index']];
$this->params['breadcrumbs'][] = "Přidat";
?>
<div class="cenova-hladina-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
