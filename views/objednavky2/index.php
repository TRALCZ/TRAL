<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Nabidky;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use app\models\Otevirani;
use app\models\Status;

use kartik\export\ExportMenu;

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

<div class="nabidky-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<!--
    <p>
        <?= Html::a('Přidat nabídku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
-->
	
<?php Pjax::begin(); ?>    

<?php

		$gridColumnsExport = [
			'id',
			'user.name',
			'cislo',
			'popis',
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
			],
            'cislo',
            'popis',
			//'datetime',
			[
				'attribute' => 'vystaveno',
				'value' => 'vystaveno',
				'format' =>  ['date', 'php:d.m.Y'],
			],
			/*
			[
				'attribute' => 'vystaveno',
				'value' => 'vystaveno',
				'format' => 'raw',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'vystaveno',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
							'language' => 'cs',
						]
				]),
			],
			*/
			[
				'attribute' => 'zakazniky_id',
				'value' => 'zakazniky.name',
			],
			
			[
				'attribute' => 'status_id',
				'value' => 'status.name',
			],
			
			[
                'format' => 'raw',
				'header'=>'Tisk',
                'value' => function($model) {
					return Html::a("<i class='fa fa-file-pdf-o' aria-hidden='true'></i>", Url::to(['create-pdf','id'=>$model->id]), 
							[
								'class'=>'btn btn-danger btn-main', 
								'target'=>'_blank', 
								'data-toggle'=>'tooltip', 
								'title'=>'Will open the generated PDF file in a new window'
							]);
                }
            ],

			/*			
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}  {delete}',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
			 * 
			 */
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
