<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\models\Ceniky;
//use app\models\Seznam;
use app\models\Typceny;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CenikySeznamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ceny');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ceniky-seznam-index">

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
				'attribute' => 'ceniky_id',
				'filter' => Html::activeDropDownList($searchModel, 'ceniky_id', ArrayHelper::map(Ceniky::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'ceniky.name'
			],
            'cena',
            [
				'attribute' => 'typceny_id',
				'filter' => Html::activeDropDownList($searchModel, 'typceny_id', ArrayHelper::map(Typceny::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => '']),
				'value' => 'typceny.name'
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
