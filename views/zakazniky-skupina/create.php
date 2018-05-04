<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikySkupina */

$this->title = Yii::t('app', 'Přidat skupinu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zakazniky Skupinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-skupina-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
