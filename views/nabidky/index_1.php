<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Nabidky;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use app\models\Otevirani;
use app\models\Status;
use app\models\Prevzit;
use app\models\Log;
use kartik\export\ExportMenu;
use kartik\cmenu\ContextMenu;
use yii\bootstrap\Modal;

use kartik\growl\Growl;
use kartik\alert\Alert;
use yii\db\ActiveRecord;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NabidkySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nabídky vystavené';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="nabidky-index">

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
        <?= Html::a('Přidat nabídku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['timeout' => false]); ?>    

	<?php

		$gridColumnsExport = [
			'id',
			'user.name',
			'cislo',
			'name',
			'vystaveno',
			'zakazniky.name',
			'status.name',
			'objednavka_vystavena',
			'faktura_vydana',
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
				'contentOptions' => ['class' => 'truncate'],
			],
            'cislo',
            'name',
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
				'attribute' => 'status_id',
				'value' => 'status.name',
			],
			[  
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width:160px;'],
				'header'=>'Změnit stav',
				'template' => '{view}',
				'buttons' => [

					//view button
					'view' => function ($url, $model) {
	
						$nabidky = Nabidky::findOne($model->id);
						$status_id = $nabidky['status_id'];

						if ($status_id <> 2)
						{
						
							$statuses = Status::find()->where(['>', 'id', 1])->andWhere(['<>', 'id', 4])->all();
							foreach($statuses as $status)
							{
								$li = $li . '<li>'.Html::a($status->name, Url::to(['change','id'=>$model->id,'newstatus_id'=>$status->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete změnit stav?', 'method' => 'post']]).' </li>';
							}
							
							return '<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle btn-main" type="button" data-toggle="dropdown">Změnit stav
									<span class="caret"></span></button>
									<ul class="dropdown-menu" style="text-align: left; border: 2px solid #204D74; margin-left: -30px; color: #204D74 !important;">' . $li . '</ul>
								</div>';

						}
						else if ($status_id == 2 && $nabidky['objednavka_vystavena'] == 0)
						{
						
							$statuses = Status::find()->where(['id' => 3])->all();
							foreach($statuses as $status)
							{
								$li = $li . '<li>'.Html::a($status->name, Url::to(['change','id'=>$model->id,'newstatus_id'=>$status->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete změnit stav?', 'method' => 'post']]).' </li>';
							}
							
							return '<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle btn-main" type="button" data-toggle="dropdown">Změnit stav
									<span class="caret"></span></button>
									<ul class="dropdown-menu" style="text-align: left; border: 2px solid #204D74; margin-left: -30px; color: #204D74 !important;">' . $li . '</ul>
								</div>';

						}

					},
				],

			],
			[  
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width:160px;'],
				'header'=>'Převzít do',
				'template' => '{view}',
				'buttons' => [

					//view button
					'view' => function ($url, $model) {
						
						$prevzits = Prevzit::find()->all();
						if ($model->status['id'] == 2) // Objednávka
						{	
							foreach($prevzits as $prevzit)
							{
								if ($prevzit->id == 1) // Objednavka vystavena
								{
									$li = $li . '<li>'.Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
								}
								else if($prevzit->id == 2) // Faktura vydana
								{
									$li = $li . '<li>'.Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
								}
								else
								{
									$li = $li . '<li>'.Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
								}
							}

							return '<div class="dropdown">
										<button class="btn btn-success dropdown-toggle btn-main" type="button" data-toggle="dropdown">Převzít do
										<span class="caret"></span></button>
										<ul class="dropdown-menu" style="text-align: left; border: 2px solid #204D74; margin-left: -30px; color: #204D74 !important;">' . $li . '</ul>
									</div>';
						}
						else if ($model->status['id'] == 4) // Dokončeno
						{
							if($model->faktura_vydana == 1 && $model->dlist_vydany == 0)
							{
								foreach($prevzits as $prevzit)
								{
									if ($prevzit->id == 3) // Dodaci list vydany
									{
										$li = $li . '<li>'.Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
									}
								}
								
								return '<div class="dropdown">
										<button class="btn btn-success dropdown-toggle btn-main" type="button" data-toggle="dropdown">Převzít do
										<span class="caret"></span></button>
										<ul class="dropdown-menu" style="text-align: left; border: 2px solid #204D74; margin-left: -30px; color: #204D74 !important;">' . $li . '</ul>
									</div>';
							}
							else if ($model->faktura_vydana == 0 && $model->dlist_vydany == 1) 
							{
								foreach($prevzits as $prevzit)
								{
									if ($prevzit->id == 2) // Faktura vydana
									{
										$li = $li . '<li>'.Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]).' </li>';
									}
								}
								
								return '<div class="dropdown">
										<button class="btn btn-success dropdown-toggle btn-main" type="button" data-toggle="dropdown">Převzít do
										<span class="caret"></span></button>
										<ul class="dropdown-menu" style="text-align: left; border: 2px solid #204D74; margin-left: -30px; color: #204D74 !important;">' . $li . '</ul>
									</div>';
							}
							
							
							
						}
							
					}

				],

			],

			[
                'format' => 'raw',
				'header'=>'Tisk',
                'value' => function($model) {
					return Html::a("<i class='fa fa-file-pdf-o' aria-hidden='true'></i>", Url::to(['create-pdf','id'=>$model->id]), 
							[
								'class'=>'btn btn-danger btn-main', 
								'target'=>'_blank', 
								//'data-toggle'=>'tooltip', 
								//'title'=>'Will open the generated PDF file in a new window'
							]);
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
                'format' => 'raw',
				'header'=>'View',
                'value' => function($model) {
					return '<div class="input_close show_view" data-nid="' .$model->id . '" data-toggle="view" data-target="#w4"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></div>';
	            }
            ],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width:30px;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width:40px;'],
			],
			
				
        ],

		
    ]); ?>
<?php Pjax::end(); ?>


</div>

<?php
/*
Modal::begin([
        'options' => [
        'id' => 'modal-log',
		'size' => Modal::SIZE_LARGE,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_LARGE,
    'header' => '<h4 style="margin:0; padding:0" id="modal-view-header">Nabidka</h4>', 
    ]);
	echo '<div id="main-show-view" class="modal-log">Loading...</div>';
Modal::end();
*/

Modal::begin([
    'options' => [
        'id' => 'modal-view',
		'size' => Modal::SIZE_LARGE,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_LARGE,
    'header' => '<h4 style="margin:0; padding:0" id="modal-view-header">Log</h4>',
    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
]);

	echo '<div id="main-show-view">Loading...</div>';

Modal::end();

?>