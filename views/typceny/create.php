<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Typceny */

$this->title = Yii::t('app', 'Přidat typ ceny');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ ceny'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typceny-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
