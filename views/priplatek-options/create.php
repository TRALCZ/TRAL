<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PriplatekOptions */

$this->title = Yii::t('app', 'Přidat příplatek pro všechny modely (řádky)');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Příplatky pro všechny modely (řádky)'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="priplatek-options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
