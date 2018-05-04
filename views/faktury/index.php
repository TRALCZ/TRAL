<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use kartik\growl\Growl;
use app\models\FakturySeznam;
use app\models\FakturyZalohove;

//use dosamigos\datepicker\DatePicker;

//use kartik\daterange\DateRangePicker;
//use kartik\date\DatePicker;
//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NabidkySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faktury vystavené';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="faktury-index">
	
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
        <?= Html::a('Přidat fakturu', ['create'], ['class' => 'btn btn-success']) ?>
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
				'header'=>'Celkem (bez DPH)',
                'value' => function($model) {
					return FakturySeznam::find()->where(['faktury_id' => $model->id])->sum('celkem');
                }
            ],
			
			[
                'format' => 'raw',
				'header'=>'Celkem (vc. DPH)',
                'value' => function($model) {
					return FakturySeznam::find()->where(['faktury_id' => $model->id])->sum('vcetne_dph');
                }
            ],
			
			[
                'attribute' => 'zaloha',
            ],
			[
                'attribute' => 'zaloha_dph',
            ],
				
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
				//'header'=>'Oprava',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width: 2%;'],
				//'visible' => UserIdentity::isAdmin()
			],
				
			[
				'class' => 'yii\grid\ActionColumn',
				//'header'=>'Oprava',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width: 3%;'],
				//'visible' => UserIdentity::isAdmin()
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