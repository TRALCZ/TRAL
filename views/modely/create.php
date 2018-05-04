<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Modely */

$this->title = Yii::t('app', 'Model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modelies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modely-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
