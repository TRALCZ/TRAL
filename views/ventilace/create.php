<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ventilace */

$this->title = Yii::t('app', 'Přidat ventilace');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ventilace'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventilace-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
