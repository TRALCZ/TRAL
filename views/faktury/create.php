<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Faktury */

$this->title = Yii::t('app', 'Přidat fakturu');
if($nab['id']>0)
{
	$this->title = Yii::t('app', 'Převzít nabídku do faktury vydané');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-create">

    <?= $this->render('_form', [
        'model' => $model,
		'nab' => $nab,
    ]) ?>

</div>
