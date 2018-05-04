<?php

//use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\growl\Growl;
//use yii\helpers\ArrayHelper;
//use app\models\Modely;

use app\models\Category;

//use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SeznamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Katalog zboží';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seznam-index">

	<?php 
		if(Yii::$app->session->hasFlash('success'))
		{	
			echo Growl::widget([
				'type' => Growl::TYPE_SUCCESS,
				'icon' => 'glyphicon glyphicon-ok-sign',
				'body' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . Yii::$app->session->getFlash('success'),
				'showSeparator' => true,
				'delay' => 0,
				'pluginOptions' => [
					'showProgressbar' => false,
					'delay' => 2000,
					'placement' => [
						'from' => 'top',
						'align' => 'right',
					]
				]
			]);
		}
		else if(Yii::$app->session->hasFlash('danger'))
		{	
			echo Growl::widget([
				'type' => Growl::TYPE_DANGER,
				'icon' => 'glyphicon glyphicon-remove-sign',
				'body' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . Yii::$app->session->getFlash('danger'),
				'showSeparator' => true,
				'delay' => 0,
				'pluginOptions' => [
					'showProgressbar' => false,
					'delay' => 2000,
					'placement' => [
						'from' => 'top',
						'align' => 'right',
					]
				]
			]);
		}
	?>
	
    <p>
		<div class='form-group field-modely required col-xs-12'>
			<a class="btn btn-app" id="vytvorit-popis" href="/seznam/create/1"><i class="fa fa-tasks"></i><br>Přidat Interiérové dveře</a>
			<!-- <a class="btn btn-app" id="vytvorit-popis" href="/seznam/create/2"><i class="fa fa-truck"></i><br>Přidat službu</a> -->
		</div>
    </p>
	
	<? 
		$category = new Category();
		$category->fullTree(0, 0);
		//Category::fullTree(0, 0); //Category::ShowTree(0, 0); 
	?>
	
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

<?php Pjax::begin(['id' => 'boxPajax',
    'timeout' => false,
    'clientOptions' => ['id' => '1']
]); ?>   
 
	<?php
	
		$gridColumnsExport = [
			'name',
			'kod',
			'min_limit',
		];
	?>

	<?php
	
	// Export xls, pdf
		echo ExportMenu::widget([
			'dataProvider' => $dataProvider,
			'columns' => $gridColumnsExport
		]);
	
	?>

	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        //    ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'uuid',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
			[
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width: 45%;'],
			],
            [
				'attribute' => 'kod',
				'contentOptions' => ['style' => 'min-width: 15%;'],
			],
			[
				'attribute' => 'hmotnost',
				'contentOptions' => ['style' => 'min-width: 15%;'],
			],
			[
				'attribute' => 'modely.image',
				'format' => 'raw',
				'value' => function ($model) {
						$img = $model->getImageUrl($model->modely_id);
						if($img)
						{
							return $img;
						}
						else
						{
							return '';
						}
					
				},
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
			
			[
				'label' => 'Kopie',
				'format' => 'raw',
				'value' => function ($model) {
						$url = $model->id;
						if($url)
						{
							return '<a href="/seznam/copy/' . $url . '"><i class="fa fa-copy"></i></a>';
						}
						else
						{
							return '';
						}
					
				},
				'contentOptions' => ['style' => 'min-width: 10%;'],
			],
					
			/*		
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width:5%;'],
			],
			*/
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width:15%;'],
			],		
        ],
    ]); ?>
	
<?php Pjax::end(); ?>



</td>
  </tr>

</table> 


</div>
