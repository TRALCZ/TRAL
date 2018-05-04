<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\XmlImport */

$this->title = Yii::t('app', 'Přidat XML-soubor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'XML Import'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xml-import-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
