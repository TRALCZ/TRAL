<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Priplatek;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PriplatekOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Příplatky pro všechny modely (řádky)');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="priplatek-options-index">

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

            'id',
            'uuid',
            [
				'attribute' => 'priplatek_id',
				'filter' => Html::activeDropDownList($searchModel, 'priplatek_id', ArrayHelper::map(Priplatek::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'priplatek.name'
			],
            'name',
            'zkratka',
			'cena',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
			
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
