<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SkladySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Seznam skladů');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sklady-index">

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
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
			[
				'attribute' => 'uuid',
				'contentOptions' => ['style' => 'min-width: 30%;'],
			],
			[
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
			[
				'attribute' => 'kod',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
