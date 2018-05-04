<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Skupiny */

$this->title = Yii::t('app', 'Přidat skupinu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Skupiny'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skupiny-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
