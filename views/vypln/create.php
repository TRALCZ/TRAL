<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vypln */

$this->title = Yii::t('app', 'Přidat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Výplň'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vypln-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
