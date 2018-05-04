<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Map;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mapy');
$this->params['breadcrumbs'][] = $this->title;

$mapModel = new Map();
?>
<div class="map-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat XML-soubor'), ['create'], ['class' => 'btn btn-success']) ?>&nbsp;&nbsp;
		<?= Html::a(Yii::t('app', 'Zobrazit mapu'), ['view', 'id' => $mapModel->zakazkaMAX()], ['class' => 'btn btn-warning']) ?>&nbsp;&nbsp;
		<?= Html::a(Yii::t('app', 'Smazat vše'), ['truncate'], ['class' => 'btn btn-danger', 'data-pjax' => 0, 'data' => ['confirm' => Yii::t('app', 'Opravdu chcete smazat všechny záznamy?'), 'method' => 'post']]) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'zakazka',
            'city',
            'address',
            'postalCode',
            'country',
            'sum',
            // 'file',
			'poznamka',
            'datetime_add',

            //['class' => 'yii\grid\ActionColumn'],
			[
				'class' => 'yii\grid\ActionColumn',
				//'header'=>'Oprava',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width: 3%;'],
				//'visible' => UserIdentity::isAdmin()
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
