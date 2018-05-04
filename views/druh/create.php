<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Druh */

$this->title = Yii::t('app', 'Přidat druh položky');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Druh položky'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="druh-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
