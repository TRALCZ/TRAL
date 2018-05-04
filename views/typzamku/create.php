<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Typzamku */

$this->title = Yii::t('app', 'Přidat typ zámku');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ zámku'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typzamku-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
