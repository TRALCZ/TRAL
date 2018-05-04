<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Nabidky;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Status;
use app\models\Prevzit;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use kartik\growl\Growl;
use app\models\Skupiny;

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
	<!--
    <p>
        <?= Html::a('Přidat nabídku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	-->
	<p>
        <div id="dialog_skupiny" class="btn btn-success">Přidat nabídku</div>
    </p>
	
	
<?php Pjax::begin(['timeout' => false]); ?>    

	<?php

		$gridColumnsExport = [
			'id',
			'user.name',
			'cislo',
			'name',
			'vystaveno',
			'zakazniky.o_name',
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
			[
				'attribute' => 'skupiny_id',
				'value' => 'skupiny.name',
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
				'value' => 'zakazniky.o_name',
			],
			
			[
				'attribute' => 'status_id',
				'value' => 'status.name',
			],
						
			[
                'format' => 'raw',
				'header' => 'Změnit stav',
				'contentOptions' => ['style' => 'min-width: 150px;'],
                'value' => function($model){
						
						$nabidky = Nabidky::findOne($model->id);
						$status_id = $nabidky['status_id'];
						
						if ($status_id <> 2 && $status_id <> 4)
						{
						
							$statuses = Status::find()->where(['>', 'id', 1])->andWhere(['<>', 'id', 4])->all();
							foreach($statuses as $status)
							{
								//$li = $li . '<li>'.Html::a($status->name, Url::to(['change','id'=>$model->id,'newstatus_id'=>$status->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete změnit stav?', 'method' => 'post']]).' </li>';
								$li = $li . Html::a($status->name, Url::to(['change','id'=>$model->id,'newstatus_id'=>$status->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete vystavit bankovní doklad?', 'method' => 'post']]);
							}
							
							return '<div class="btn-group">
									<a class="btn btn-primary btn-main" href="#"><i class="fa fa-refresh fa-fw"></i> Změnit stav</a>
									<a class="btn btn-primary dropdown-toggle btn-main" data-toggle="dropdown" href="#">
									  <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
									</a>
									<ul class="dropdown-menu">
										<li>'.$li.'</li>
									</ul>		
								</div>';

						}
						else if ($status_id == 2 && $nabidky['objednavka_vystavena'] == 0)
						{
						
							$statuses = Status::find()->where(['id' => 3])->all();
							foreach($statuses as $status)
							{
								//$li = $li . '<li>'.Html::a($status->name, Url::to(['change','id'=>$model->id,'newstatus_id'=>$status->id]), ['class' => 'btn btn-default btn-xs', 'data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete změnit stav?', 'method' => 'post']]).' </li>';
								$li = $li . Html::a($status->name, Url::to(['change','id'=>$model->id,'newstatus_id'=>$status->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete vystavit bankovní doklad?', 'method' => 'post']]);
							}
							
							return '<div class="btn-group">
									<a class="btn btn-primary btn-main" href="#"><i class="fa fa-refresh fa-fw"></i> Změnit stav</a>
									<a class="btn btn-primary dropdown-toggle btn-main" data-toggle="dropdown" href="#">
									  <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
									</a>
									<ul class="dropdown-menu">
										<li>'.$li.'</li>
									</ul>		
								</div>';

						}
						else if($status_id == 4) // Dokonceno
						{
							return '';
						}
						else
						{
							return '';
						}
					
                }
            ],			
						
						
						
						
						
			[
                'format' => 'raw',
				'header' => 'Převzit',
				'contentOptions' => ['style' => 'min-width: 150px;'],
                'value' => function($model) {
						
						$prevzits = Prevzit::find()->all();
						if ($model->status['id'] == 2) // Objednávka
						{	
							foreach($prevzits as $prevzit)
							{
								if ($prevzit->id == 1) // Objednavka vystavena
								{
									$li = $li . Html::a($prevzit->name, Url::to(['../objednavky/create?idn=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
								else if($prevzit->id == 2) // Faktura vydana
								{
									$li = $li . Html::a($prevzit->name, Url::to(['../faktury/create?idn=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
								else if($prevzit->id == 3) // Dlist vydany
								{
									$li = $li . Html::a($prevzit->name, Url::to(['../dlist/create?idn=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
								else if($prevzit->id == 4) // Faktura zalohova
								{
									$li = $li . Html::a($prevzit->name, Url::to(['../faktury-zalohove/create?idn=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
								else
								{
									$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
							}

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
						else if ($model->status['id'] == 4) // Dokončeno
						{
							if($model->faktura_vydana == 1 && $model->dlist_vydany == 0)
							{
								foreach($prevzits as $prevzit)
								{
									if ($prevzit->id == 3) // Dodaci list vydany
									{
										$li = $li . Html::a($prevzit->name, Url::to(['../dlist/create?idn=' . $model->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
										//$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
									}
								}
								
								return '<div class="btn-group">
									<a class="btn btn-success btn-main" href="#"><i class="fa fa-plus fa-fw"></i> Převzít do</a>
									<a class="btn btn-success dropdown-toggle btn-main" data-toggle="dropdown" href="#">
									  <span class="fa fa-caret-down"></span>
									</a>
									<ul class="dropdown-menu">
										<li>'.$li.'</li>
									</ul>		
								</div>';
							}
							else if ($model->faktura_vydana == 0 && $model->dlist_vydany == 1) 
							{
								foreach($prevzits as $prevzit)
								{
									if ($prevzit->id == 2) // Faktura vydana
									{
										$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
									}
								}
								
								return '<div class="btn-group">
									<a class="btn btn-success btn-main" href="#"><i class="fa fa-plus fa-fw"></i> Převzít do</a>
									<a class="btn btn-success dropdown-toggle btn-main" data-toggle="dropdown" href="#">
									  <span class="fa fa-caret-down"></span>
									</a>
									<ul class="dropdown-menu">
										<li>'.$li.'</li>
									</ul>		
								</div>';
							}
							
							
							
						}
						else
						{
							return '';
						}
							
							
					}

			],

/*			
			[
                'format' => 'raw',
				'header' => 'Převzit',
				'contentOptions' => ['style' => 'min-width: 150px;'],
                'value' => function($model) {
						
						$prevzits = Prevzit::find()->all();
						if ($model->status['id'] == 2) // Objednávka
						{	
							foreach($prevzits as $prevzit)
							{
								if ($prevzit->id == 1) // Objednavka vystavena
								{
									$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
								else if($prevzit->id == 2) // Faktura vydana
								{
									$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
								else
								{
									$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
								}
							}

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
						else if ($model->status['id'] == 4) // Dokončeno
						{
							if($model->faktura_vydana == 1 && $model->dlist_vydany == 0)
							{
								foreach($prevzits as $prevzit)
								{
									if ($prevzit->id == 3) // Dodaci list vydany
									{
										$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
									}
								}
								
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
							else if ($model->faktura_vydana == 0 && $model->dlist_vydany == 1) 
							{
								foreach($prevzits as $prevzit)
								{
									if ($prevzit->id == 2) // Faktura vydana
									{
										$li = $li . Html::a($prevzit->name, Url::to(['prevzit','id'=>$model->id,'prevzit_id'=>$prevzit->id]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete prevzit objednávku?', 'method' => 'post']]);
									}
								}
								
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
							
							
							
						}
						else
						{
							return '';
						}
							
							
					}

			],	
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


Modal::begin([
    'options' => [
        'id' => 'modal-view2',
		'size' => Modal::SIZE_DEFAULT,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_DEFAULT,
    'header' => '<h4 style="margin:0; padding:0" id="modal-view-header">Vyberte skupinu</h4>',
    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
]);

	
		
echo '<div id="main-show-view">';

	$ml = Skupiny::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'skupiny_id',
		'value' => 1,
		'data' => $listData1,
		'options' => [
				'id' => 'skupiny-nabidky',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);

echo '
	<div id="znac-select" style="display: none;">1</div>
	<div class="form-group field-seznam-cena_s_dph required">
		<button class="btn btn-success btn-100" type="submit" id="submit_vybrat_skupiny"  style="margin-top: 22px; width: 50%; margin-left: 20%;" >Vybrat</button>
	</div>
</div>';

Modal::end();



?>