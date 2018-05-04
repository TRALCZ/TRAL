<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikyCenovaHladina */

$this->title = Yii::t('app', 'Create Zakazniky Cenova Hladina');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zakazniky Cenova Hladinas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-cenova-hladina-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
