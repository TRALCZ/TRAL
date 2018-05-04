<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use app\models\PdokladFz;
use app\models\BdokladFz;
use kartik\growl\Growl;

//use dosamigos\datepicker\DatePicker;

//use kartik\daterange\DateRangePicker;
//use kartik\date\DatePicker;
//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NabidkySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faktury zálohové';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="faktury-zalohove-index">
	
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
        <?= Html::a('Přidat zálohovou fakturu', ['create'], ['class' => 'btn btn-success']) ?>
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
				'attribute' => 'celkem',
				'value' => 'celkem',
			],
			[
				'attribute' => 'celkem_dph',
				'value' => 'celkem_dph',
			],
			
			[
				'format' => 'raw',
				'header'=>'Uhrazeno (Kč)',
				'value' => function($model) {
					$psum = (float)PdokladFz::find()->where(['faktury_zalohove_id'=>$model->id])->andWhere(['smazat'=>'0'])->sum('castka');
					$bsum = (float)BdokladFz::find()->where(['faktury_zalohove_id'=>$model->id])->andWhere(['smazat'=>'0'])->sum('castka');
					
					return floatval($psum + $bsum);
				}
			],	
				
			[
                'format' => 'raw',
				'header' => 'Doklady',
				'contentOptions' => ['style' => 'min-width: 150px;'],
                'value' => function($model) {
					$li = Html::a('<i class="fa fa-file-o fa-fw"></i> Pokladní doklad', Url::to(["../pdoklad-fz/create?fz={$model->id}"]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete vystavit pokladní doklad?', 'method' => 'post']]);
					$li = $li . Html::a('<i class="fa fa-file-text-o fa-fw"></i> Bankovní doklad', Url::to(["../bdoklad-fz/create?fz={$model->id}"]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete vystavit bankovní doklad?', 'method' => 'post']]);
					$li = $li . Html::a('<i class="fa fa-clipboard fa-fw"></i> Daňový doklad', Url::to(["../ddoklad-fz/create?fz={$model->id}"]), ['data-pjax' => 0, 'data' => ['confirm' => 'Opravdu chcete vystavit bankovní doklad?', 'method' => 'post']]);
					return '<div class="btn-group">
								<a class="btn btn-primary btn-main" href="#"><i class="fa fa-file-text-o fa-fw"></i> Vystavit</a>
								<a class="btn btn-primary dropdown-toggle btn-main" data-toggle="dropdown" href="#">
								  <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
								</a>
								<ul class="dropdown-menu">
									<li>'.$li.'</li>
								</ul>		
							</div>';
                }
            ],	
				
			[
                'format' => 'raw',
				'header' => 'Tisk',
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