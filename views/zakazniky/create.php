<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Zakazniky */

$this->title = 'Přidat zákazníka';
$this->params['breadcrumbs'][] = ['label' => 'Zákazníky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
