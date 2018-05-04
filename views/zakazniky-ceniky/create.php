<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikyCeniky */

$this->title = Yii::t('app', 'Create Zakazniky Ceniky');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zakazniky Cenikies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-ceniky-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
