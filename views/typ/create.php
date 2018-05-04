<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Typ */

$this->title = Yii::t('app', 'Přidat typ zboží');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ zboží'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typ-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
