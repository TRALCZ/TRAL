<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Zakazniky */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zákazníky', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-view">

    <p>
        <?= Html::a('Opravit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Smazat', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Opravdu chcete smazat tohoto zákazníka2?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            'email:email',
            'ico',
            'dic',
            'kontaktni_osoba',
            'f_ulice',
            'f_mesto',
            'f_psc',
            'f_zeme',
            'd_ulice',
            'd_mesto',
            'd_psc',
            'd_zeme',
            'datetime',
        ],
    ]) ?>

</div>
