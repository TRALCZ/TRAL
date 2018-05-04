<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sklady */

$this->title = Yii::t('app', 'Sklady');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sklady'), 'url' => ['index']];
$this->params['breadcrumbs'][] = "Přidat";
?>
<div class="sklady-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
