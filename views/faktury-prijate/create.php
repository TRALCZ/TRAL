<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Faktury */

$this->title = Yii::t('app', 'Přidat fakturu přijatou');
if($obj['id']>0)
{
	$this->title = Yii::t('app', 'Převzít objednávku do faktury přijaté');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury přijaté'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-create">

    <?= $this->render('_form', [
        'model' => $model,
		'obj' => $obj,
    ]) ?>

</div>
