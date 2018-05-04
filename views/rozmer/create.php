<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rozmer */

$this->title = Yii::t('app', 'Přidat rozměr');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rozměr'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rozmer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
