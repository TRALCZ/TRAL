<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ZpusobyPlatby */

$this->title = 'Přidat způsob platby';
$this->params['breadcrumbs'][] = ['label' => 'Způsoby platby', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zpusoby-platby-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
