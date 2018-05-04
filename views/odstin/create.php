<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Odstin */

$this->title = Yii::t('app', 'Přidat odstín');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Odstíny'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="odstin-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
