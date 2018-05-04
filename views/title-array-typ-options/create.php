<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TitleArrayTypOptions */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Title Array Typ Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-array-typ-options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
