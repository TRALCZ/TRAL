<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Klice */

$this->title = Yii::t('app', 'Přidat kliče');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Klices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="klice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
