<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Objednavky */

$this->title = Yii::t('app', 'Přidat objednávku vystavenu');
if($nab['id']>0)
{
	$this->title = Yii::t('app', 'Převzít nabídku do objednávky vystavené');
}
	
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Objednávky'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="objednavky-create">

     <?= $this->render('_form', [
        'model' => $model, 
		'nab' => $nab,
    ]) ?>

</div>
