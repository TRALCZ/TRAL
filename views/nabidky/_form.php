<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use dosamigos\datepicker\DatePicker;

use app\models\Zakazniky;
use app\models\Seznam;
use app\models\Skupiny;
use app\models\ZpusobyPlatby;
use app\models\NabidkySeznam;
use app\models\Category;
use app\models\SeznamSearch;
use app\models\ZakaznikySkupina;
use app\models\ZakaznikySearch;
use app\models\Norma;
use app\models\Modely;
use app\models\Rozmer;
use app\models\Otevirani;
use app\models\Typzamku;
use app\models\Vypln;
use app\models\Ventilace;
use app\models\CenikySeznam;
use app\models\Ceniky;
use app\models\Sklady;
use app\models\Jednotka;

/* @var $this yii\web\View */
/* @var $model app\models\Nabidky */
/* @var $form yii\widgets\ActiveForm */

$skupina = Yii::$app->request->get('skupina');

?>

<div class="nabidky-form">

<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'cislo')->hiddenInput()->label(false); ?>
	
	<div class="form-group field-modely required col-xs-2">
	<?
		$zp = Skupiny::find()->all();
		$listData = ArrayHelper::map($zp, 'id', 'name');

		echo $form->field($model, 'skupiny_id')->widget(Select2::classname(), [
			'data' => $listData,
			'options' => [
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide',
				'value' => $skupina,
			],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
	?>
	</div>
	
	<div style="float: left;" class="col-xs-4">
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?php
			if ($model->vystaveno && $model->vystaveno <> '1970-01-01')
			{
				$vystaveno = date("d.m.Y", strtotime($model->vystaveno));
			}
			else
			{
				$vystaveno = date("d.m.Y");
			}

			echo '<label class="control-label">Dat.vystavení</label>';
			echo DatePicker::widget([
				'name' => 'Nabidky[vystaveno]',
				'value' => $vystaveno,
				'language' => 'cs',
				'template' => '{addon}{input}',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'dd.mm.yyyy',
					]
			]);
		?>
	</div>

	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?
			if ($model->platnost && $model->platnost <> '1970-01-01')
			{
				$platnost = date("d.m.Y", strtotime($model->platnost));
			}
			else
			{
				$platnost = date("d.m.Y", strtotime("+3 week"));
			}
			echo '<label class="control-label">Dat.platností</label>';
			echo DatePicker::widget([
				'name' => 'Nabidky[platnost]',
				'value' => $platnost,
				'language' => 'cs',
				'template' => '{addon}{input}',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'dd.mm.yyyy'
					]
			]);
		?>
	</div>

	<div class="form-group field-modely required col-xs-2">
	<?
		$zp = ZpusobyPlatby::find()->all();
		$listData = ArrayHelper::map($zp, 'id', 'name');

		echo $form->field($model, 'zpusoby_platby_id')->widget(Select2::classname(), [
			'data' => $listData,
			'options' => [
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
			],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
	?>
	</div>

	<div style="float: left; display: block;" class="col-xs-6" id="nabidka_zakazniky">

	<?	
		// The controller action that will render the list
		$url = Url::to(['site/zakazniky-list']);

		// The widget
		//use kartik\widgets\Select2; // or kartik\select2\Select2
		//use app\models\Zakazniky;

		// Get the initial city description
		$cityDesc = empty($model->zakazniky_id) ? '' : Zakazniky::findOne($model->zakazniky_id)->o_name;

		echo $form->field($model, 'zakazniky_id')->widget(Select2::classname(), [
			'initValueText' => $cityDesc, // set the initial display text
			'options' => ['placeholder' => '--- Vyberte ---', 'class' => 'change-zakazniky_id'],
			'pluginOptions' => [
				'allowClear' => true,
				'minimumInputLength' => 1,
				'language' => [
					'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
				],
				'ajax' => [
					'url' => $url,
					'dataType' => 'json',
					'data' => new JsExpression('function(params) { return {q:params.term}; }')
				],
				'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
				'templateResult' => new JsExpression('function(zakazniky_id) { return zakazniky_id.text; }'),
				'templateSelection' => new JsExpression('function (zakazniky_id) { return zakazniky_id.text; }'),
				'id' => 'zakazniky_id',
			],
			]);
	?>

	</div>

	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'celkem')->textInput(['maxlength' => true, 'id' => 'suma-celkem', 'readonly' => 'true']) ?>
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'celkem_dph')->textInput(['maxlength' => true, 'id' => 'suma-vcetene-dph', 'readonly' => 'true']) ?>
	</div>
	
<?
	if (!$model->user_id)
	{
		$userId = Yii::$app->user->id;
	}

	echo $form->field($model, 'user_id')->hiddenInput(['value' => $userId])->label(false);
?>

	<? $model->datetime_add = date('Y-m-d H:i:s'); ?>

	<?= $form->field($model, 'datetime_add')->hiddenInput()->label(false) ?>
	<?= $form->field($model, 'status_id')->hiddenInput()->label(false) ?>

	<? 
		if ($model->id > 0)
		{
			$countNS = NabidkySeznam::getCountNabidkySeznam($model->id);
		} 
	?>

	<div class="form-group col-xs-12" >
		<label class="control-label" for="nabidky-odberatel_id">Položky vystavené nabidky</label> <span id="add_nabidka_polozka" data-count="<?= $countNS + 1 ?>">Přidat položku</span>
		<div class="nabidka-polozky" id="nabidka_polozky">



			<!-- Update -->
<?
if ($model->id > 0)
{
	$dataNS = NabidkySeznam::getNabidkySeznam($model->id);
	$m = 1;
	foreach ($dataNS as $ns)
	{
		$ids = $ns['seznam_id'];
		$seznam = Seznam::findOne($ids);
		$idm = $seznam['modely_id'];
		?>

			<div class="polozky-line" id="polozky-line-<?= $m ?>">

				<div class="col-xs-4">Název: <input type="text" name="polozka<?= $m ?>" id="polozka<?= $m ?>" data-polozka="<?= $m ?>" class="polozky form-control" autocomplete="off" value="<?= $ns['name'] ?>" readonly />
					<span class="input_close show_modal" data-polozka="<?= $m ?>" data-toggle="modal" data-target="#w3">vyberte</span>
					<span class="input_close show_konstrukter" data-polozka="<?= $m ?>" data-toggle="konstrukter" data-target="#w4">konstrukter</span>
					<span class="input_close" data-polozka="<?= $m ?>">odstranit</span>
				</div>
				<div class="col-xs-2">Kód: <input type="text" id="kod<?= $m ?>" class="kod form-control" value="<?= $ns['kod'] ?>" readonly /></div>
				<div class="col-xs-2">Cena: <input type="text" name="cena<?= $m ?>" id="cena<?= $m ?>" class="cena form-control" data-cena="<?= $ns['cena'] ?>" data-seznam="<?= $seznam_cena_bez_dph ?>" value="<?= $ns['cena'] ?>" readonly /></div>
				<div class="col-xs-2">Typ ceny: <select name="typ_ceny<?= $m ?>" id="typ_ceny<?= $m ?>" class="typ_ceny form-control" data-polozka="<?= $m ?>" >
						<option value="bez_dph" <? if ($ns['typ_ceny'] == 'bez_dph'): ?>selected<? endif; ?> >bez DPH</option>																					
						<option value="s_dph" <? if ($ns['typ_ceny'] == 's_dph'): ?>selected<? endif; ?> >s DPH</option>																					
						<option value="jen_zaklad" <? if ($ns['typ_ceny'] == 'jen_zaklad'): ?>selected<? endif; ?> >jen zaklad</option>
					</select>
				</div>
				<div class="col-xs-2">Sazba DPH: <select name="sazba_dph<?= $m ?>" id="sazba_dph<?= $m ?>" class="sazba_dph form-control" data-polozka="<?= $m ?>" >
						<option value="0" <? if ($ns['sazba_dph'] == '0'): ?>selected<? endif; ?> >0</option>																					
						<option value="10" <? if ($ns['sazba_dph'] == '10'): ?>selected<? endif; ?> >10</option>																					
						<option value="15" <? if ($ns['sazba_dph'] == '15'): ?>selected<? endif; ?> >15</option>																					
						<option value="21" <? if ($ns['sazba_dph'] == '21'): ?>selected<? endif; ?> >21</option>
					</select>
				</div>
				<div class="col-xs-2">Pocet MJ: <input type="text" name="pocet<?= $m ?>" id="pocet<?= $m ?>" class="pocet-mj form-control" data-polozka="<?= $m ?>" value="<?= $ns['pocet'] ?>" /></div>
				<div class="col-xs-2">Sleva: <input type="text" name="sleva<?= $m ?>" id="sleva<?= $m ?>" class="sleva form-control" data-polozka="<?= $m ?>" value="<?= $ns['sleva'] ?>" /></div>
				<div class="col-xs-2">Celkem: <input type="text" name="celkem<?= $m ?>" id="celkem<?= $m ?>" class="celkem form-control" value="<?= $ns['celkem'] ?>" readonly /></div>
				<div class="col-xs-2">DPH: <input type="text" name="celkem_dph<?= $m ?>" id="celkem_dph<?= $m ?>" class="celkem_dph form-control" value="<?= $ns['celkem_dph'] ?>" readonly /></div>
				<div class="col-xs-2">Vcetne DPH: <input type="text" name="vcetne_dph<?= $m ?>" id="vcetne_dph<?= $m ?>" class="vcetne_dph form-control" value="<?= $ns['vcetne_dph'] ?>" readonly /></div>
				<div class="col-xs-2"><button class="close-polozka btn btn-danger" data-id="<?= $m ?>">X</button></div>
				<input type="hidden" name="idpolozka<?= $m ?>" id="idpolozka<?= $m ?>" value="<?= $ns['seznam_id'] ?>" />
				<div class="polozky-under-<?= $m ?>" style="display: none;"></div>

			</div>		



		<?
		$m++;
	}
}
?>

			<!-- / Update -->

		</div>
	</div>

	<input type="hidden" id="count_polozka" name="count_polozka" value=<? if ($countNS > 0): ?>"<?= $countNS ?>"<? else: ?>"0"<? endif; ?> />

	<div class="form-group col-xs-12">
		<?= Html::a('Zpět', ['/nabidky/index'], ['class'=>'btn btn-success btn-100']) ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		<? if(Yii::$app->request->get('faktura_vydana') == 1): ?>
			<?= Html::submitButton($model->isNewRecord ? 'Uložít' : 'Uložít', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100 f-vydana' : 'btn btn-primary btn-100 f-vydana', id=>'btn_submit', idn=>$model->id]) ?>
		<? elseif(Yii::$app->request->get('dlist_vydany') == 1): ?>
			<?= Html::submitButton($model->isNewRecord ? 'Uložít' : 'Uložít', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100 f-vydana' : 'btn btn-primary btn-100 f-vydana', id=>'btn_submit', idn=>$model->id]) ?>
		<? else: ?>
			<?= Html::submitButton($model->isNewRecord ? 'Uložít' : 'Uložít', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', id=>'btn_submit']) ?>
		<? endif; ?>
	</div>

<?php ActiveForm::end(); ?>


<?
	$searchModel = new SeznamSearch();
	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	// Modal

	Modal::begin([
			//'header' => '<h2>Seznam</h2>',
			// 'toggleButton' => ['label' => 'click me'],
			'size' => Modal::SIZE_LARGE,
	]);

		Category::fullTree(0, 0);

		Pjax::begin([
			'id' => 'boxPajax',
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
				'uuid',
				[
					'attribute' => 'name',
					'contentOptions' => ['style' => 'min-width:400px;'],
					'format' => 'raw',
					'value' => function($data) {
						$cs = CenikySeznam::find()->where(['seznam_id' => $data->id])->one();
						return Html::a(Html::encode($data->name), '#', ['class' => 'vybrat-item',
								'data-id' => $data->id,
								'data-name' => $data->name,
								'data-kod' => $data->kod,
								'data-cena' => $cs->cena,
								//'data-cena' => $data->cena_bez_dph,
								//'data-is_cenova_hladina' => 'Ne',
						]);
					},
				],
				'kod',
				[
					'attribute' => 'cena',
					'format' => 'raw',
					'value' => function ($data) {
						$cs = CenikySeznam::find()->where(['seznam_id' => $data->id])->one();
						return $cs->cena;
					},
				],		
				//'stav',
				//'rezerva',
				//'objednano',
				//'predpoklad_stav',
				//'cena_bez_dph',
				//'min_limit',
				//'cena_s_dph',
			],
		]);

		Pjax::end();

		echo '
</td>
  </tr>

</table>';

	Modal::end();
?>	

<?
	$searchModelZ = new ZakaznikySearch();
	$dataProviderZ = $searchModelZ->search(Yii::$app->request->queryParams);

	// Modal

	Modal::begin([
			'options' => [
				'id' => 'modalZ',
				//'size' => Modal::SIZE_LARGE,
				//'tabindex' => false // important for Select2 to work properly
			],
			'size' => Modal::SIZE_LARGE,
			'header' => '<h4 style="margin:0; padding:0">Přidat odběratele</h4>',
	]);

		ZakaznikySkupina::fullTree(0,0);

		Pjax::begin([
			'id' => 'boxPajaxZ',
			'timeout' => false,
			'clientOptions' => ['id' => '1']
		]);

		echo GridView::widget([
			'dataProvider' => $dataProviderZ,
			'filterModel' => $searchModelZ,
			'summary' => "Zobrazeno <strong>{begin} - {end}</strong> z <strong>{totalCount}</strong> položek",
			'layout' => "{items}\n<div style='float: left; width: 70%;'>{pager}</div><div style='float: right; width: 30%; text-align: right;'>{summary}</div>",
			'columns' => [
				//    ['class' => 'yii\grid\SerialColumn'],
				[
					'attribute' => 'name',
					'contentOptions' => ['style' => 'min-width:400px;'],
					'format' => 'raw',
					'value' => function($data) {
						return Html::a(Html::encode($data->o_name), '#', ['class' => 'vybrat-zakaznika',
								'data-id' => $data->id,
								'data-name' => $data->o_name,
								'data-ico' => $data->ico,
								'data-fulice' => $data->f_ulice,
								'data-fmesto' => $data->f_mesto,
								'data-fpsc' => $data->f_psc,
								//'data-is_cenova_hladina' => 'Ne',
						]);
					},
				],
				'phone',
				'email:email',
				'ico',
				'dic',
				'kontaktni_osoba',
			],
		]);

		Pjax::end();

		echo '
</td>
  </tr>

</table>';

	Modal::end();
?>	
	
	


	
<?

// Using a select2 widget inside a modal dialog
Modal::begin([
    'options' => [
        'id' => 'modal2',
		'size' => Modal::SIZE_LARGE,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_LARGE,
    'header' => '<h4 style="margin:0; padding:0">Přidat položku (Interiérové dveře)</h4>',
    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
]);


echo '<input id="typ1" class="form-control" name="Seznam[typ_id]" value="1" readonly="" maxlength="" type="hidden">';

echo '<div class="form-group field-modely required col-xs-3">';
echo "<label class='control-label' for='norma1'>Norma</label><br>";

	$ml = Norma::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'norma_id',
		'value' => 1,
		'data' => $listData1,
		'options' => [
				'id' => 'norma1',
				'data-zkratka' => 'CZ',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo "<label class='control-label' for='norma1'>Model</label><br>";

	$ml = Modely::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'modely_id',
		'data' => $listData1,
		'options' => [
				'id' => 'model1',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo "<label class='control-label' for='norma1'>Odstín</label><br>";

	echo DepDrop::widget([
		'name' => 'odstin_id',
		'type' => DepDrop::TYPE_SELECT2,
		'data'=>$selected,
		//'data' => [2 => 'Tablets'],
		'options' => [
			'id' => 'odstin1',
			//'data'=>[2 => 'Tablets'],
			'placeholder' => '--- Vyberte ---',
			'multiple' => false,
			'class' => 'hide',
		],
		'select2Options' => [
			'pluginOptions' => ['allowClear'=>true]
		],
		'pluginOptions' => [
			'allowClear' => true,
			'initialize' => true,
			'depends' => ['model1'],
			'placeholder' => '--- Vyberte ---',
			'url' => Url::to(['/site/odstiny']),
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo "<label class='control-label' for='norma1'>Rozměr</label><br>";

	$ml = Rozmer::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'rozmer_id',
		'data' => $listData1,
		'options' => [
				'id' => 'rozmer1',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo "<label class='control-label' for='norma1'>Typ otevírání dveří</label><br>";

	$ml = Otevirani::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'otevirani_id',
		'data' => $listData1,
		'options' => [
				'id' => 'otevirani1',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Typ zámku');

	$ml = Typzamku::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'typzamku_id',
		'data' => $listData1,
		'options' => [
				'id' => 'typzamku1',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Výplň');

	$ml = Vypln::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'vypln_id',
		'value' => 1,
		'data' => $listData1,
		'options' => [
				'id' => 'vypln1',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';


echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Ventilace');

	$ml = Ventilace::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'ventilace_id',
		'value' => 1,
		'data' => $listData1,
		'options' => [
				'id' => 'ventilace1',
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);
	
echo '</div>';

echo '
<div class="form-group field-modely required col-xs-6">
	<div class="form-group field-seznam-name required">
		<label class="control-label" for="seznam-name">Název</label>
		<input id="seznam-name" class="form-control" name="Seznam[name]" readonly="" maxlength="255" aria-required="true" type="text">
		<div class="help-block"></div>
	</div>
</div>';

echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Jednotka');

	$ml = Jednotka::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'jednotka_id',
		'data' => $listData1,
		'value' => 1,
		'options' => [
			'id' => 'jednotka1',
			'placeholder' => '--- Vyberte ---',
			'multiple' => false,
			'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);

echo '</div>';

echo '
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-cena_bez_dph required">
		<label class="control-label" for="seznam-cena_bez_dph">Cena bez DPH</label>
		<input id="seznam-cena_bez_dph" class="form-control" name="cena_bez_dph" value="0.00" aria-required="true" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>';

echo '
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-min_limit">
		<label class="control-label" for="seznam-min_limit">Čárový kód</label>
		<input id="seznam-carovy_kod" class="form-control" name="Seznam[carovy_kod]" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>';

echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Ceniky');

	$ml = Ceniky::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'ceniky_id',
		'data' => $listData1,
		'value' => 1,
		'options' => [
			'id' => 'ceniky1',
			'placeholder' => '--- Vyberte ---',
			'multiple' => false,
			'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);

echo '</div>';

echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Sklady');

	$ml = Sklady::find()->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'name');

	echo Select2::widget([
		'name' => 'sklady_id',
		'data' => $listData1,
		'value' => 1,
		'options' => [
			'id' => 'sklady1',
			'placeholder' => '--- Vyberte ---',
			'multiple' => false,
			'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);

echo '</div>';

echo '<div class="form-group field-modely required col-xs-3">';
echo Html::label('Dodavatel');

	$ml = Zakazniky::find()->where(['zakazniky_skupina_id' => '2'])->all();
	$listData1 = ArrayHelper::map($ml, 'id', 'o_name');

	echo Select2::widget([
		'name' => 'zakazniky_id',
		'data' => $listData1,
		'value' => 89,
		'options' => [
			'id' => 'zakazniky1',
			'placeholder' => '--- Vyberte ---',
			'multiple' => false,
			'class' => 'hide'
		],
		'pluginOptions' => [
			'allowClear' => true
		],
	]);

echo '</div>';

echo '<div class="col-xs-12" style="float: left; height: 1px;"></div>';

echo '
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-hmotnost">
		<label class="control-label" for="seznam-min_limit">Hmotnost</label>
		<input id="seznam-hmotnost" class="form-control" name="Seznam[hmotnost]" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>';

echo '
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-dodaci_lhuta">
		<label class="control-label" for="seznam-min_limit">Dodací lhůta</label>
		<input id="seznam-dodaci_lhuta" class="form-control" name="Seznam[dodaci_lhuta]" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>';

echo '
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-zasoba_pojistna">
		<label class="control-label" for="seznam-min_limit">Zásoba pojistná</label>
		<input id="zasoba_pojistna" class="form-control" name="zasoba_pojistna" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>';

/*	
echo "<div class='form-group field-modely required col-xs-12'>";
	echo Html::textInput('popis1', '', ['maxlength' => true, 'readonly' => true]);
echo '</div>';
*/
echo '
<input id="polozka_id" name="polozka_id" value="0" aria-required="true" aria-invalid="false" type="hidden">

<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-cena_s_dph required">
		<button class="btn btn-success btn-100" type="submit" id="submit_konstrukter" style="margin-top: 22px; width: 50%; margin-left: 20%;">Přidat</button>
	</div>
</div>
';


Modal::end();

?>	


	
	
</div>

