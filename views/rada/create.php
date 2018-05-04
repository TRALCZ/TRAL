<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rada */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Řady'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rada-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
