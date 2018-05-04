<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DlistPrijatySeznam */

$this->title = Yii::t('app', 'Create Dlist Prijaty Seznam');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dlist Prijaty Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dlist-prijaty-seznam-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
