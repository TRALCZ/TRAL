<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;

use yii\helpers\Url;

use kartik\select2\Select2;

use app\models\Zakazniky;
use app\models\Seznam;
use app\models\Nabidky;
use app\models\NabidkySeznam;
//use dosamigos\datepicker\DatePicker;

use kartik\date\DatePicker;

//use app\models\ZakaznikySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Nabidky */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="nabidky-form">

    <?php $form = ActiveForm::begin(); ?>

	<div style="float: left;" class="col-xs-2">
		<?= $form->field($model, 'cislo'); ?>
	</div>	
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
	<?
		
	if($model->vystaveno && $model->vystaveno <> '1970-01-01')
	{
		$vystaveno = date("Y-m-d", strtotime($model->vystaveno));
	}
	else
	{
		$vystaveno = date("Y-m-d");
	}
	
	echo '<label class="control-label">Dat.vystavení</label>';
	echo DatePicker::widget([
		'name' => 'Nabidky[vystaveno]',
		'type' => DatePicker::TYPE_COMPONENT_APPEND,
		'value' => $vystaveno,
		'language' => 'cs',
		'readonly' => true,
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'yyyy-mm-dd'
		]
	]);
	?>
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
	<?
	if($model->platnost && $model->platnost <> '1970-01-01')
	{
		$platnost = date("Y-m-d", strtotime($model->platnost));
	}
	else
	{
		$platnost = date("Y-m-d", strtotime("+3 week"));
	}
	echo '<label class="control-label">Dat.platností</label>';
	echo DatePicker::widget([
		'name' => 'Nabidky[platnost]',
		'type' => DatePicker::TYPE_COMPONENT_APPEND,
		'value' => $platnost,
		'language' => 'cs',
		'readonly' => true,
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'yyyy-mm-dd'
		]
	]);
	?>
	</div>
	
	
	
	
	<div style="float: left;" class="col-xs-12">
		<?= $form->field($model, 'popis')->textInput(['maxlength' => true]) ?>
	</div>
	

	
	<div class="form-group field-modely required col-xs-2">
		<? 
			$zp = \app\models\ZpusobyPlatby::find()->all(); 
			$listData=ArrayHelper::map($zp,'id','name');	

			//echo Select2::widget([
			echo $form->field($model, 'zpusoby_platby_id')->widget(Select2::classname(), [
				//'name' => 'zpusoby_platby_id',
				'data' => $listData,
				//'value' => '-',
				'options' => [
						'placeholder' => '--- Vyberte ---',
						'multiple' => false,
						'class'=>'hide'
					],
					'pluginOptions' => [
						'allowClear' => true
					],
			]); 
		?>
	</div>
	
	
	
	
	<div style="float: left; display: block;" class="col-xs-10">
	
	<?	

	$data = Zakazniky::getZakazniky();
	foreach($data as $dat)
	{
		$names[] = [$dat[id] => $dat[name] . ' (' . $dat[f_ulice] . ', ' . $dat[f_mesto] . ', ' . $dat[f_psc] . ', ' . $dat[f_zeme] . ')' ];
	}

	echo $form->field($model, 'zakazniky_id')->widget(Select2::classname(), [
		'data' => $names,
		'options' => [
			'placeholder' => '--- Vyberte ---',
			'multiple' => false,
			'class'=>'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	?>
	</div>
	
		
	<?
	if(!$model->user_id)
	{
		$userId = Yii::$app->user->id;
	}
	
	echo $form->field($model, 'user_id')->hiddenInput(['value'=> $userId])->label(false);
	
	?>
	
	<? $model->datetime_add = date('Y-m-d H:i:s'); ?>
	<? $model->status_id = 1; ?>
	
    <?= $form->field($model, 'datetime_add')->hiddenInput()->label(false) ?>
	<?= $form->field($model, 'status_id')->hiddenInput()->label(false) ?>
	
	<?	if($model->id > 0) { $countNS = NabidkySeznam::getCountNabidkySeznam($model->id); } ?>
	
	<div class="form-group col-xs-12" >
	<label class="control-label" for="nabidky-odberatel_id">Položky vystavené nabidky</label> <span id="add_nabidka_polozka" data-count="<?=$countNS+1?>">Přidat položku</span>
		<div class="nabidka-polozky" id="nabidka_polozky">
		
		
		
		<!-- Update -->
		<?
			if($model->id > 0)
			{
				$dataNS = NabidkySeznam::getNabidkySeznam($model->id);
				$m = 1;
				foreach($dataNS as $ns)
				{
		?>
				
				<div class="polozky-line" id="polozky-line-<?=$m?>">
				
					<div class="col-xs-4">Popis: <input type="text" name="polozka<?=$m?>" id="polozka<?=$m?>" data-polozka="<?=$m?>" class="polozky form-control" autocomplete="off" value="<?=$ns['popis']?>" readonly />
						<span class="input_close show_modal" data-polozka="<?=$m?>" data-toggle="modal" data-target="#w3">vyberte</span>
						<span class="input_close" data-polozka="<?=$m?>">odstranit</span>
						<span style="margin-left: 250px;">
							<input type="checkbox" id="checkpopis<?=$m?>" class="checkpopis" style="margin: 0 0 0 0;" data-polozka="<?=$m?>">&nbsp;&nbsp;Opravit popis
						</span>
					</div>
					<div class="col-xs-2">PLU: <input type="text" id="plu<?=$m?>" class="plu form-control" value="<?=$ns['plu']?>" readonly /></div>
					<div class="col-xs-2">Cena: <input type="text" name="cena<?=$m?>" id="cena<?=$m?>" class="cena form-control" data-cena="" value="<?=$ns['cena']?>" readonly /></div>
					<div class="col-xs-2">Typ ceny: <select name="typ_ceny<?=$m?>" id="typ_ceny<?=$m?>" class="typ_ceny form-control" data-polozka="<?=$m?>" >
														<option value="bez_dph" <? if ($ns['typ_ceny'] == 'bez_dph'):?>selected<? endif; ?> >bez DPH</option>																					
														<option value="s_dph" <? if ($ns['typ_ceny'] == 's_dph'):?>selected<? endif; ?> >s DPH</option>																					
														<option value="jen_zaklad" <? if ($ns['typ_ceny'] == 'jen_zaklad'):?>selected<? endif; ?> >jen zaklad</option>
													</select>
					</div>
					<div class="col-xs-2">Sazba DPH: <select name="sazba_dph<?=$m?>" id="sazba_dph<?=$m?>" class="sazba_dph form-control" data-polozka="<?=$m?>" >
														<option value="0" <? if ($ns['sazba_dph'] == '0'):?>selected<? endif; ?> >0</option>																					
														<option value="10" <? if ($ns['sazba_dph'] == '10'):?>selected<? endif; ?> >10</option>																					
														<option value="15" <? if ($ns['sazba_dph'] == '15'):?>selected<? endif; ?> >15</option>																					
														<option value="21" <? if ($ns['sazba_dph'] == '21'):?>selected<? endif; ?> >21</option>
													</select>
					</div>
					<div class="col-xs-2">Pocet MJ: <input type="text" name="pocet<?=$m?>" id="pocet<?=$m?>" class="pocet-mj form-control" data-polozka="<?=$m?>" value="<?=$ns['pocet']?>" /></div>
					<div class="col-xs-2">Sleva: <input type="text" name="sleva<?=$m?>" id="sleva<?=$m?>" class="sleva form-control" data-polozka="<?=$m?>" value="<?=$ns['sleva']?>" /></div>
					<div class="col-xs-2">Celkem: <input type="text" name="celkem<?=$m?>" id="celkem<?=$m?>" class="celkem form-control" value="<?=$ns['celkem']?>" readonly /></div>
					<div class="col-xs-2">DPH: <input type="text" name="celkem_dph<?=$m?>" id="celkem_dph<?=$m?>" class="celkem_dph form-control" value="<?=$ns['celkem_dph']?>" readonly /></div>
					<div class="col-xs-2">Vcetne DPH: <input type="text" name="vcetne_dph<?=$m?>" id="vcetne_dph<?=$m?>" class="vcetne_dph form-control" value="<?=$ns['vcetne_dph']?>" readonly /></div>
					<div class="col-xs-2"><button class="close-polozka btn btn-danger" data-id="<?=$m?>">X</button></div>
					<input type="hidden" name="idpolozka<?=$m?>" id="idpolozka<?=$m?>" value="<?=$ns['seznam_id']?>" />
					<div class="polozky-under-<?=$m?>" style="display: none;"></div>
				
				</div>		
				
			
				
		<?
				$m++;
			}
		}
		?>
		
		<!-- / Update -->

	
		
		</div>
	</div>
	
	<input type="hidden" id="count_polozka" name="count_polozka" value=<? if($countNS > 0): ?>"<?=$countNS?>"<? else:?>"0"<? endif; ?> />
	
	
    <div class="form-group col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? 'Uložít' : 'Uložít', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


	
<?

use app\models\Category; 
use app\models\SeznamSearch;
$searchModel = new SeznamSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

// Modal

Modal::begin([
    //'header' => '<h2>Seznam</h2>',
   // 'toggleButton' => ['label' => 'click me'],
	'size' => Modal::SIZE_LARGE,
]);

Category::fullTree(0,0);
	
Pjax::begin(['id' => 'boxPajax',

    'timeout' => false,
    'clientOptions' => ['id' => '1']

]);

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'summary' => "Zobrazeno <strong>{begin} - {end}</strong> z <strong>{totalCount}</strong> položek",
		'layout' => "{items}\n<div style='float: left; width: 70%;'>{pager}</div><div style='float: right; width: 30%; text-align: right;'>{summary}</div>",
        'columns' => [
        //    ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'popis',
				'contentOptions' => ['style' => 'min-width:400px;'],
				'format' => 'raw',
                'value' => function($data){
					return Html::a(Html::encode($data->popis), '#', ['class' => 'vybrat-item', 
																	'data-id' => $data->id, 
																	'data-popis' => $data->popis, 
																	'data-plu' => $data->plu,
																	'data-cena' => $data->cena_bez_dph,
																]);
                },
			],
            'plu',
            'stav',
            'rezerva',
            'objednano',
            'predpoklad_stav',
            'cena_bez_dph',
            'min_limit',
            'cena_s_dph',
            [
				'label'=>'Vybrat',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(Html::encode("Vybrat"), '#', ['class' => 'vybrat-item', 
																	'data-id' => $data->id, 
																	'data-popis' => $data->popis, 
																	'data-plu' => $data->plu,
																	'data-cena' => $data->cena_bez_dph,
																]);
				},
			],
			/*[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
				'contentOptions' => ['style' => 'min-width:50px;'],
			],*/
        ],
    ]);
	
Pjax::end();

echo '
</td>
  </tr>

</table>';

Modal::end();


?>	
	
	
	
	
	
	
	
	
	
</div>

 

<?
/*
$urlAjax = Url::to(['site/ajax']);
$token = Yii::$app->request->getCsrfToken();
$js = new \yii\web\JsExpression(<<< JS
		
		
		$('#nabidka_polozky').on('input', '.polozky', function() {
				var id = $(this).data('polozka');
				var text = $(this).val();
				
				$.ajax({
				url: '$urlAjax',
				type: 'post',
				data: { id: id, text: text, _csrf: '$token' },
				success: function(data)
				{
					
					$('.polozky-under-' + id).html(data);
					$('.polozky-under-' + id).show();

				}
			});
				
				
				//alert(count);
		  });

		
		
		
		
      
JS
);

$this->registerJs($js, static::POS_END);	
*/