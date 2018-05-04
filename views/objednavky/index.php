<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\ObjednavkySeznam;
use yii\helpers\Url;
use kartik\growl\Growl;

use kartik\export\ExportMenu;

use yii\bootstrap\Modal;

//use dosamigos\datepicker\DatePicker;

//use kartik\daterange\DateRangePicker;
//use kartik\date\DatePicker;
//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NabidkySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Objednávky vystavené';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="objednavky-index">
	
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
	?>
	
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Přidat objednávku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    

	<?php

		$gridColumnsExport = [
			'id',
			'user.name',
			'cislo',
			'popis',
			'vystaveno',
			'zakazniky.name'
		];
	?>


	<?php
	// Renders a export dropdown menu
		echo ExportMenu::widget([
			'dataProvider' => $dataProvider,
			'columns' => $gridColumnsExport
		]);
	?>




<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

            
			[
				'attribute' => 'id',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
			[
				'attribute' => 'user_id',
				'value' => 'user.name',
			],
            'cislo',
            'popis',
			//'datetime',
			[
				'attribute' => 'vystaveno',
				'value' => 'vystaveno',
				'format' =>  ['date', 'php:d.m.Y'],
			],
			[
				'attribute' => 'zakazniky_id',
				'value' => 'zakazniky.name',
			],
			[
				'format' => 'raw',
				'contentOptions' => ['style' => 'width:160px;'],
				'header'=>'Stav',
				'value' => function($model) {
					$objednavkySeznam = ObjednavkySeznam::find()->where(['objednavky_id' => $model->id])->all();

					foreach($objednavkySeznam as $s)
					{
						$pocet = (int)$s['pocet'];
						$prijato = (int)$s['prijato'];
						$sum = $prijato - $pocet;
						if ($sum >= 0)
						{
							$count1 = 0;
						}
						else 
						{
							$count1 = 1;
						}
						
						$count = $count + $count1;
					}
					
					if ($count == 0)
					{
						$stav = '<span style="color: green;">Vyřízeno</span>';
					}
					else
					{
						$stav = 'Nevyřízeno';
					}
					
					return $stav;
                },
			],
					
			[  
				'format' => 'raw',
				'header' => 'Převzit',
				'contentOptions' => ['style' => 'min-width: 150px;'],
                'value' => function($model) {
						
					$li = Html::a("Faktura přijatá", Url::to(['../faktury-prijate/create?ido=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
					//$li = $li . Html::a($prevzit->name, Url::to(['../objednavky/create?ido=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
					$li = $li . Html::a("Dodací list přijatý", Url::to(['../dlist-prijaty/create?ido=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
					return '<div class="btn-group">
									<a class="btn btn-success btn-main" href="#"><i class="fa fa-plus fa-fw"></i> Převzít do</a>
									<a class="btn btn-success dropdown-toggle btn-main" data-toggle="dropdown" href="#">
									  <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
									</a>
									<ul class="dropdown-menu">
										<li>'.$li.'</li>
									</ul>		
								</div>';
					}

			],		
					
			/*		
			[  
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width:160px;'],
				'header'=>'Převzít do',
				'template' => '{view}',
				'buttons' => [

					//view button
					'view' => function ($url, $model) {
						
					$li = '<li>'.Html::a("Faktura přijatá", Url::to(['prevzit', 'id'=>$model->id, 'prevzit_id'=>1]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
					$li = $li . '<li>'.Html::a("Dodací list přijatý", Url::to(['prevzit', 'id'=>$model->id, 'prevzit_id'=>2]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
					return '<div class="dropdown">
								<button class="btn btn-success dropdown-toggle btn-main" type="button" data-toggle="dropdown">Převzít do
								<span class="caret"></span></button>
								<ul class="dropdown-menu" style="text-align: left; border: 2px solid #204D74; margin-left: -30px; color: #204D74 !important;">' . $li . '</ul>
							</div>';
					}
				],

			],
			 * 
			 */
			[
                'format' => 'raw',
				'header'=>'Tisk',
                'value' => function($model) {
					return Html::a("<i class='fa fa-file-pdf-o' aria-hidden='true'></i>", Url::to(['print','id'=>$model->id]), ['data-pjax' => '0']);
                }
            ],

			[
                'format' => 'raw',
				'header'=>'Log',
                'value' => function($model) {
					return Html::tag("div", "<i class='fa fa-align-justify' aria-hidden='true'></i>", ['id'=>'modal-btn-'.$model->id, 'class'=>'modal-btn-log', 'data-id'=>$model->id, 'data-controller'=>Yii::$app->controller->id]);
                }
            ],
			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Oprava',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width: 2%;'],
			],	
			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Oprava',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width: 3%;'],
			],
        ],
    ]); ?>
<?php Pjax::end(); ?>


</div>

<?php
    Modal::begin([
        'header' => 'Log',
        'id' => 'modal',
//		/'style' => 'width: 800px;'
        //'size' => 'modal-lg',       
    ]);
?>
<div id='modal-content' class='modal-log'>Loading...</div>
<?php Modal::end(); ?>