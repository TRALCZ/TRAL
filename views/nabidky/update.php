<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nabidky */

if(Yii::$app->request->get('dlist_vydany') == 1)
{
	$this->title = 'Převzít nabídku č. ' . $model->id . ' do dodacího listu vydaného';
}
else if(Yii::$app->request->get('faktura_zalohova') == 1)
{
	$this->title = 'Převzít nabídku č. ' . $model->id . ' do zálohové faktury';
}
else
{
	$this->title = 'Opravit nabídku č. ' . $model->id;
}

$this->params['breadcrumbs'][] = ['label' => 'Nabidky vystavené', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Opravit';
?>

<div class="nabidky-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
