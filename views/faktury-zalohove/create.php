<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FakturyZalohove */

$this->title = Yii::t('app', 'Přidat zálohovou fakturu');
if($nab['id']>0)
{
	$this->title = Yii::t('app', 'Převzít nabídku do zálohové faktury');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury zálohové'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-zalohove-create">

    <?= $this->render('_form', [
        'model' => $model,
		'nab' => $nab,
    ]) ?>

</div>
