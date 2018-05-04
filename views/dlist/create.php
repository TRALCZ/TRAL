<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dlist */

$this->title = Yii::t('app', 'Přidat dodací list');
if($nab['id']>0)
{
	$this->title = Yii::t('app', 'Převzít nabídku do dodacího listu vydaného');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dodací list'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dlist-create">

    <?= $this->render('_form', [
        'model' => $model,
		'nab' => $nab,
    ]) ?>

</div>
