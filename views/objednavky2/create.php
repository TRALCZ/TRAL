<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Nabidky */

$this->title = 'Přidat nabídku';
$this->params['breadcrumbs'][] = ['label' => 'Nabídky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="nabidky-create">

    <?= $this->render('_form', [
        'model' => $model,
		
		// default
		$model->cislo = 'NV16-01',
    ]) ?>
	
	

</div>
