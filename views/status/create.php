<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Status */

$this->title = Yii::t('app', 'Přidat status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
