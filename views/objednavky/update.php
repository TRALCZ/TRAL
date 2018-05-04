<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Objednavky */

if(Yii::$app->request->get('faktura_prijata') == 1)
{
	$this->title = 'Převzít objednávku (Faktura přijatá) č.' . $model->id;
}
else if(Yii::$app->request->get('dlist_prijaty') == 1)
{
	$this->title = 'Převzít objednávku (Dodací list přijatý) č.' . $model->id;
}
else
{
	$this->title = 'Opravit objednávku vystavenu: ' . $model->cislo;
}

//$this->title = 'Opravit objednávku: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Objednávky vystavené', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Opravit';
?>

<div class="objednavky-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
