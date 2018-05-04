<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cinnost */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Činnost'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cinnost-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
