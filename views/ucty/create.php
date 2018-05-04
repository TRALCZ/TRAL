<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ucty */

$this->title = Yii::t('app', 'Přidat účet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Účty'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ucty-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
