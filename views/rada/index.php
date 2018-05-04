<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Zakazniky;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RadaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Řady');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rada-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'id',
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
			[
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width: 40%;'],
			],
			[
				'attribute' => 'zakazniky_id',
				'filter' => Html::activeDropDownList($searchModel, 'zakazniky_id', ArrayHelper::map(Zakazniky::find()->where(['zakazniky_skupina_id' => 2])->asArray()->all(), 'id', 'o_name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'zakazniky.o_name',
				'contentOptions' => ['style' => 'min-width: 40%;'],
			],
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
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
