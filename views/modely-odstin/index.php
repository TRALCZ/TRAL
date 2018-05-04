<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Modely;
use app\models\Odstin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModelyOdstinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Odstín modelu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modely-odstin-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?php Pjax::begin(); ?>    

		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				// ['class' => 'yii\grid\SerialColumn'],
				[
					'attribute' => 'id',
					'contentOptions' => ['style' => 'min-width: 10%;'],
				],
				[
					'attribute' => 'modely_id',
					'filter' => Html::activeDropDownList($searchModel, 'modely_id', ArrayHelper::map(Modely::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => '']),
					'value' => 'modely.name',
					'contentOptions' => ['style' => 'min-width: 30%;'],
				],
				[
					'attribute' => 'odstin_id',
					'filter' => Html::activeDropDownList($searchModel, 'odstin_id', ArrayHelper::map(Odstin::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => '']),
					'value' => 'odstin.name',
					'contentOptions' => ['style' => 'min-width: 30%;'],
				],
				[
					'attribute' => 'cena_odstin',
					'contentOptions' => ['style' => 'min-width: 20%;'],
				],
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{update} {delete}',
					'contentOptions' => ['style' => 'min-width: 10%;'],
				],
			],
		]); 
		?>

	<?php Pjax::end(); ?>

</div>
