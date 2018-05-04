<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Seznam */

$this->title = 'Seznam položka id=' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seznam', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seznam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Opravdu chcete smazat položku?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'popis',
            'plu',
            'stav',
            'rezerva',
            'objednano',
            'predpoklad_stav',
            'cena_bez_dph',
            'min_limit',
            'cena_s_dph',
        ],
    ]) ?>

</div>
