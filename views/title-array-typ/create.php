<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TitleArrayTyp */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Title Array Typ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-array-typ-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
