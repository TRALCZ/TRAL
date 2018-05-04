<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Rada;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ModelySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Model');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modely-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?
	echo newerton\fancybox\FancyBox::widget([
					'target' => 'a[rel=fancybox]',
					'helpers' => false,
					'mouse' => true,
					'config' => [
						//'maxWidth' => '50%',
						//'maxHeight' => '800px',
						'playSpeed' => 7000,
						'padding' => 0,
						'fitToView' => false,
						//'width' => '70%',
						//'height' => '50%',
						'autoSize' => false,
						'closeClick' => false,
						'openEffect' => 'elastic',
						'closeEffect' => 'elastic',
						'prevEffect' => 'elastic',
						'nextEffect' => 'elastic',
						'closeBtn' => false,
						'openOpacity' => true,
						'helpers' => [
							'title' => ['type' => 'float'],
							'buttons' => [],
							'thumbs' => ['width' => 68, 'height' => 50],
							'overlay' => [
								'css' => [
									'background' => 'rgba(0, 0, 0, 0.8)'
								]
							]
						],
					]
				]);
	?>
	
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        //  ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'id',
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
			[
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width: 35%;'],
			],
			[
				'attribute' => 'rada_id',
				'filter' => Html::activeDropDownList($searchModel, 'rada_id', ArrayHelper::map(Rada::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'rada.name',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
			[
				'attribute' => 'cena',
				'contentOptions' => ['style' => 'min-width: 15%;'],
			],
			[
				'attribute' => 'image',
				'contentOptions' => ['style' => 'min-width: 10%;'],
				'format' => 'raw',    
				'value' => function ($model) {
					return $model->getImageUrl();
				},
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
		],
    ]); ?>
<?php Pjax::end(); ?></div>
<!--
<a href="/images/models/thumbs/ALEJA_03-800x800.jpg" rel="fancybox"><img class="" src="/images/models/thumbs/ALEJA_03-800x800.jpg" alt="" style="height: 300px; border: 1px solid #3C8DBC; border-radius: 10px; padding: 10px;"></a>
-->
