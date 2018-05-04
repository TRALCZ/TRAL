<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use app\models\Seznam;
use app\models\Sklady;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SkladySeznamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sklady');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sklady-seznam-index">

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

            //'id',
            'uuid',

			[
				'attribute' => 'seznam_id',
				'value' => 'seznam.name'
			],
            [
				'attribute' => 'sklady_id',
				'filter' => Html::activeDropDownList($searchModel, 'sklady_id', ArrayHelper::map(Sklady::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'sklady.name'
			],
			[
				'attribute' => 'stav_zasoby',
				'contentOptions' => ['style' => 'min-width:10%;'],
			],
			[
				'attribute' => 'objednano',
				'contentOptions' => ['style' => 'min-width:10%;'],
			],
			[
				'attribute' => 'rezervace',
				'contentOptions' => ['style' => 'min-width:10%;'],
			],
			[
				'attribute' => 'predpokladny_stav',
				'contentOptions' => ['style' => 'min-width:10%;'],
			],
			[
				'attribute' => 'zasoba_pojistna',
				'contentOptions' => ['style' => 'min-width:10%;'],
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width:50px;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width:50px;'],
			],
        ],
    ]); ?>
	
    <?php Pjax::end(); ?>
</div>
