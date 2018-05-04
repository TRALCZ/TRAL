<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SkupinySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Skupiny');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skupiny-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'id',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
            [
				'attribute' => 'id_ms',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
            [
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width: 30%;'],
			],
            [
				'attribute' => 'cinnost_id',
				'value' => 'cinnost.kod',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
            [
				'attribute' => 'stredisko_id',
				'value' => 'stredisko.kod',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
	
</div>
