<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Status');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'id',
				'contentOptions' => ['style' => 'min-width: 15%;'],
			],
            [
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width: 50%;'],
			],
			[
				'attribute' => 'zkratka',
				'contentOptions' => ['style' => 'min-width: 25%;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
