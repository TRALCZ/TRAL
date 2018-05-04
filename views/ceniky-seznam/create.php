<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CenikySeznam */

$this->title = Yii::t('app', 'Seznam ceníků');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seznam ceníků'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Přidat';
?>
<div class="ceniky-seznam-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
