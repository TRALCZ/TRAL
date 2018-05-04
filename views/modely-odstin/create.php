<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ModelyOdstin */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Odstín modelu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modely-odstin-create">

     <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
