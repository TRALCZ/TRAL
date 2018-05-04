<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FakturyPrijateSeznam */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faktury Prijate Seznams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-prijate-seznam-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'faktury_prijate_id',
            'seznam_id',
            'pocet',
            'cena',
            'typ_ceny',
            'sazba_dph',
            'sleva',
            'celkem',
            'celkem_dph',
            'vcetne_dph',
        ],
    ]) ?>

</div>
