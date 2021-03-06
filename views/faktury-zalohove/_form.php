<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\Zakazniky;
use app\models\Seznam;
use app\models\NabidkySeznam;
use app\models\FakturyZalohoveSeznam;
use app\models\ZpusobyPlatby;
use dosamigos\datepicker\DatePicker;
use kartik\depdrop\DepDrop;
use yii\web\JsExpression;

//use app\models\ZakaznikySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Nabidky */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faktury-zalohove-form">

<?php $form = ActiveForm::begin(); ?>
	<?
		if (Yii::$app->controller->action->id == 'create')
		{
			if($nab['id'] > 0)
			{
				$nabidky_id = $nab['id'];
			}
			else
			{
				$nabidky_id = 0;
			}
		}
		else
		{
			$nabidky_id = $model->nabidky_id;
		}
	?>
	<?= $form->field($model, 'nabidky_id')->hiddenInput(['value' => $nabidky_id])->label(false); ?>
	<?= $form->field($model, 'cislo')->hiddenInput()->label(false); ?>
	
	<div style="float: left;" class="col-xs-6">
		<?
			if (Yii::$app->controller->action->id == 'create')
			{
				$popis = $nab['popis'];
			} 
			else
			{
				$popis = $model->popis;
			}
		?>
		<?= $form->field($model, 'popis')->textInput(['value' => $popis, 'maxlength' => true]) ?>
	</div>
	
	<div class="form-group field-faktury-zalohove-vystaveno required col-xs-2">
		<?php
			if (Yii::$app->controller->action->id == 'create')
			{
				if($nab['id'] > 0)
				{
					$vystaveno = date("d.m.Y", strtotime($nab['vystaveno']));
				}
				else
				{
					$vystaveno = date("d.m.Y");
				}
			} 
			else
			{
				if ($model->vystaveno && $model->vystaveno <> '1970-01-01')
				{
					$vystaveno = date("d.m.Y", strtotime($model->vystaveno));
				}
				else
				{
					$vystaveno = date("d.m.Y");
				}
			}

			echo '<label class="control-label">Dat.vystavení</label>';
			echo DatePicker::widget([
				'name' => 'FakturyZalohove[vystaveno]',
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

	<div class="form-group field-faktury-zalohove-vystaveno required col-xs-2">
		<?
			if (Yii::$app->controller->action->id == 'create')
			{
				if($nab['id'] > 0)
				{
					$platnost = date("d.m.Y", strtotime($nab['platnost']));
				}
				else
				{
					$platnost = date("d.m.Y", strtotime("+3 week"));
				}
			} 
			else
			{
				if ($model->platnost && $model->platnost <> '1970-01-01')
				{
					$platnost = date("d.m.Y", strtotime($model->platnost));
				}
				else
				{
					$platnost = date("d.m.Y", strtotime("+3 week"));
				}
			}
			echo '<label class="control-label">Dat.platností</label>';
			echo DatePicker::widget([
				'name' => 'FakturyZalohove[platnost]',
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
			if (Yii::$app->controller->action->id == 'create')
			{
				$zpusoby_platby_id = $nab['zpusoby_platby_id'];
			} 
			else
			{
				$zpusoby_platby_id = $model->zpusoby_platby_id;
			}
			$zp = ZpusobyPlatby::find()->all();
			$listData = ArrayHelper::map($zp, 'id', 'name');

			echo $form->field($model, 'zpusoby_platby_id')->widget(Select2::classname(), [
				'data' => $listData,
				'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class' => 'hide',
					'value' => $zpusoby_platby_id
				],
				'pluginOptions' => [
					'allowClear' => true
				],
			]);
		?>
	</div>

	<div style="float: left; display: block;" class="col-xs-6">
		
		<?	
		if (Yii::$app->controller->action->id == 'create')
		{
			//$zakazniky_id = $nab['zakazniky_id'];
			$zakazniky = empty($nab['zakazniky_id']) ? '' : Zakazniky::findOne($nab['zakazniky_id'])->name;
			$zakazniky_id = $nab['zakazniky_id'];
		} 
		else
		{
			$zakazniky = empty($model->zakazniky_id) ? '' : Zakazniky::findOne($model->zakazniky_id)->name;
			$zakazniky_id = $model->zakazniky_id;
		}
		
		$url = Url::to(['site/zakazniky-list']);

		echo $form->field($model, 'zakazniky_id')->widget(Select2::classname(), [
			'initValueText' => $zakazniky, // set the initial display text
			'options' => ['placeholder' => '--- Vyberte ---', 'class' => 'change-zakazniky_id', 'value' => $zakazniky_id],
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
			],
			]);
		?>
		
		<!--
		<?
		$data = Zakazniky::getZakazniky();
		foreach ($data as $dat)
		{
			$names[] = [$dat[id] => $dat[name] . ' (' . $dat[f_ulice] . ', ' . $dat[f_mesto] . ', ' . $dat[f_psc] . ', ' . $dat[f_zeme] . ')'];
		}

		echo $form->field($model, 'zakazniky_id')->widget(Select2::classname(), [
			'data' => $names,
			'options' => [
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class' => 'hide',
				'id' => 'zakazniky_id',
			],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
		?>
		-->
	</div>
	
	<div class="form-group field-faktury-zalohove-vystaveno required col-xs-3">
		<label class="control-label">Suma položek celkem</label>
		<input id="suma-celkem" class="form-control" aria-required="true" type="text" name="suma_celkem_bez_dph" readonly>
	</div>
	<div class="form-group field-faktury-zalohove-vystaveno required col-xs-3">
		<label class="control-label">Suma položek včetně DPH</label>
		<input id="suma-vcetene-dph" class="form-control" aria-required="true" type="text" name="suma_celkem_s_dph" readonly>
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-6">&nbsp;</div>
	
	<div class="form-group field-faktury-zalohove-vystaveno required col-xs-2">
		<label class="control-label">Částka v %</label>
		<input id="castka_procent" class="form-control" aria-required="true" type="text" name="castka_procent">
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'celkem')->textInput(['maxlength' => true]) ?>
	</div>
	
	<div class="form-group field-nabidky-vystaveno required col-xs-2">
		<?= $form->field($model, 'celkem_dph')->textInput(['maxlength' => true]) ?>
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

	<? 
		if ($model->id > 0)
		{
			$countNS = FakturyZalohoveSeznam::getCountFakturyZalohoveSeznam($model->id);
		}
		else if($nab['id'] > 0)
		{
			$countNS = NabidkySeznam::getCountNabidkySeznam($nab['id']);
		}
	?>

	<div class="form-group col-xs-12" >
		<label class="control-label" for="nabidky-odberatel_id">Položky zalohové faktury</label> <span id="add_nabidka_polozka" data-count="<?=$countNS+1?>">Přidat položku</span>
		<div class="nabidka-polozky" id="nabidka_polozky">



			<!-- Update -->
<?
if ($model->id > 0 || $nab['id'] > 0)
{
	if($model->id > 0)
	{
		$dataNS = FakturyZalohoveSeznam::getFakturyZalohoveSeznam($model->id);
	}
	else if ($nab['id'])
	{
		$dataNS = NabidkySeznam::getNabidkySeznam($nab['id']);
	}
	
	$m = 1;
	foreach ($dataNS as $ns)
	{
		$ids = $ns['seznam_id'];
		$seznam = Seznam::find()->where(['id' => $ids])->one();
		$seznam_cena_bez_dph = $seznam['cena_bez_dph'];
		$idm = $seznam['modely_id'];
		?>

			<div class="polozky-line" id="polozky-line-<?= $m ?>">

				<div class="col-xs-4">Popis: <input type="text" name="polozka<?= $m ?>" id="polozka<?= $m ?>" data-polozka="<?= $m ?>" class="polozky form-control" autocomplete="off" value="<?= $ns['popis'] ?>" readonly />
					<span class="input_close show_modal" data-polozka="<?= $m ?>" data-toggle="modal" data-target="#w3">vyberte</span>
					<span class="input_close show_konstrukter" data-polozka="<?= $m ?>" data-toggle="konstrukter" data-target="#w4">konstrukter</span>
					<span class="input_close" data-polozka="<?= $m ?>">odstranit</span>
				</div>
				<div class="col-xs-2">PLU: <input type="text" id="plu<?= $m ?>" class="plu form-control" value="<?= $ns['plu'] ?>" readonly /></div>
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
				<div class="col-xs-2">Počet MJ: <input type="text" name="pocet<?= $m ?>" id="pocet<?= $m ?>" class="pocet-mj form-control" data-polozka="<?= $m ?>" value="<?= $ns['pocet'] ?>"/></div>
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
		<?= Html::a('Zpět', ['/faktury-zalohove/index'], ['class'=>'btn btn-success btn-100']) ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?= Html::submitButton($model->isNewRecord ? 'Uložít' : 'Uložít', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', id=>'btn_submit']) ?>
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
				[
					'attribute' => 'popis',
					'contentOptions' => ['style' => 'min-width:400px;'],
					'format' => 'raw',
					'value' => function($data) {
						return Html::a(Html::encode($data->popis), '#', ['class' => 'vybrat-item',
								'data-id' => $data->id,
								'data-popis' => $data->popis,
								'data-plu' => $data->plu,
								'data-cena' => $data->cena_bez_dph,
								//'data-is_cenova_hladina' => 'Ne',
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

	$ml = \app\models\Norma::find()->all();
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

	$ml = \app\models\Modely::find()->all();
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

	$ml = \app\models\Rozmer::find()->all();
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

	$ml = \app\models\Otevirani::find()->all();
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
echo "<label class='control-label' for='norma1'>Typ zámku</label><br>";

	$ml = \app\models\Typzamku::find()->all();
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
echo "<label class='control-label' for='norma1'>Výplň</label><br>";

	$ml = \app\models\Vypln::find()->all();
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
echo "<label class='control-label' for='norma1'>Ventilace</label><br>";

	$ml = \app\models\Ventilace::find()->all();
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
<div class="form-group field-modely required col-xs-12">
	<div class="form-group field-seznam-popis required">
		<label class="control-label" for="seznam-popis">Popis</label>
		<input id="seznam-popis" class="form-control" name="Seznam[popis]" readonly="" maxlength="255" aria-required="true" type="text">
		<div class="help-block"></div>
	</div>
</div>';
/*	
echo "<div class='form-group field-modely required col-xs-12'>";
	echo Html::textInput('popis1', '', ['maxlength' => true, 'readonly' => true]);
echo '</div>';
*/
echo '
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-min_limit">
		<label class="control-label" for="seznam-min_limit">Min.limit</label>
		<input id="seznam-min_limit" class="form-control" name="Seznam[min_limit]" value="1" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-cena_bez_dph required">
		<label class="control-label" for="seznam-cena_bez_dph">Cena bez DPH</label>
		<input id="seznam-cena_bez_dph" class="form-control" name="Seznam[cena_bez_dph]" value="0.00" aria-required="true" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-cena_s_dph required">
		<label class="control-label" for="seznam-cena_s_dph">Cena s DPH</label>
		<input id="seznam-cena_s_dph" class="form-control" name="Seznam[cena_s_dph]" value="0.00" aria-required="true" aria-invalid="false" type="text">
		<div class="help-block"></div>
	</div>
</div>
<div class="form-group field-modely required col-xs-3">
	<div class="form-group field-seznam-cena_s_dph required">
		<button class="btn btn-success btn-lg" type="submit" id="submit_konstrukter"  style="margin-top: 15px; width: 50%; margin-left: 20%;" >Přidat</button>
	</div>
</div>
<!--
<div class="form-group field-modely required col-xs-3" style="margin-top: 10px;">
	<button class="btn btn-success" type="submit" id="submit_konstrukter">Přidat</button>
</div>
-->
';


Modal::end();







//use yii\bootstrap\ActiveForm;
	Modal::begin([
		'id' => 'modal21',
		'size' => Modal::SIZE_LARGE,
		//'tabindex' => false // important for Select2 to work properly
	]);
	
	echo "<input type='text'>";
	
	echo '<div style="">';
				$ml = \app\models\Norma::find()->all();
				$listData1 = ArrayHelper::map($ml, 'id', 'name');

				echo '<div class="form-group field-modely required col-xs-3">';
				echo Select2::widget([
					'name' => 'norma_id',
					
					'data' => $listData1,
					'value' => 1,
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
	echo '</div>';
	
	echo '<div style="">';
				$ml = \app\models\Modely::find()->all();
				$listData1 = ArrayHelper::map($ml, 'id', 'name');

				echo '<div class="form-group field-modely required col-xs-3">';
				echo Select2::widget([
					'name' => 'state_40',
					'data' => $listData1,
					'options' => ['placeholder' => 'Select a state ...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				]);

	echo '</div>';
				
	Modal::end();
	
		
?>

	
	
	
</div>