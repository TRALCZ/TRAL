<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prevzit */

$this->title = Yii::t('app', 'Create Prevzit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prevzits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prevzit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
