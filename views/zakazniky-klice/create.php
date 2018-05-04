<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ZakaznikyKlice */

$this->title = Yii::t('app', 'Create Zakazniky Klice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zakazniky Klices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-klice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
