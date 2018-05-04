<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Otevirani */

$this->title = Yii::t('app', 'Přidat typ otevírání dveří');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Typ otevírání dveří'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="otevirani-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
