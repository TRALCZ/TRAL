<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Faktury */

$this->title = Yii::t('app', 'Přidat dodací list přijatý');
if($obj['id']>0)
{
	$this->title = Yii::t('app', 'Převzít objednávku do dodacího lista přijatého');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dodací listy přijaté'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dlist-prijaty-create">

    <?= $this->render('_form', [
        'model' => $model,
		'obj' => $obj,
    ]) ?>

</div>
