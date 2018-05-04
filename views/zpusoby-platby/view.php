<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ZpusobyPlatby */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Způsoby platby', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zpusoby-platby-view">

    <p>
        <?= Html::a('Opravit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Smazat', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Opravdu chcete smazat tento způsob platby?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
