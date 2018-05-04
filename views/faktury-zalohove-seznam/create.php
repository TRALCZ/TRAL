<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FakturyZalohoveSeznam */

$this->title = Yii::t('app', 'Create Faktury Zalohove Seznam');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury Zalohove Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-zalohove-seznam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
