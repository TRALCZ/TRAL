<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ceniky */

$this->title = Yii::t('app', 'Ceníky');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ceníky'), 'url' => ['index']];
$this->params['breadcrumbs'][] = "Přidat";
?>
<div class="ceniky-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
