<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\growl\Growl;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PdokladFzSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bankovní doklad');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bdoklad-fz-index">
	
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
        <!-- <?= Html::a(Yii::t('app', 'Přidat bankovní doklad'), ['create'], ['class' => 'btn btn-success']) ?> -->
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
				'header'=>'Číslo zálohové faktury',
				'attribute' => 'faktury_zalohove_id',
				'value' => 'faktury_zalohove.cislo',
			],
			[
				'attribute' => 'user_id',
				'value' => 'user.name',
			],
            'cislo',
			//'datetime',
			[
				'attribute' => 'vystaveno',
				'value' => 'vystaveno',
				'format' =>  ['date', 'php:d.m.Y'],
			],
			[
				'attribute' => 'castka',
				'header'=>'Častka (Kč)',
				'value' => 'castka',
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