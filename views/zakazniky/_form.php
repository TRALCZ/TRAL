<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\checkbox\CheckboxX;

use yii\jui\AutoComplete;
use yii\helpers\Url;

use kartik\tabs\TabsX;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\grid\GridView;

use app\models\CenovaHladina;
use app\models\Seznam;
use app\models\Countries;
use app\models\ZakaznikySkupina;
use app\models\Klice;
use app\models\Ceniky;

//use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Zakazniky */
/* @var $form yii\widgets\ActiveForm */

$skupina = Yii::$app->request->get('skupina');

?>

<div class="zakazniky-form">

    <?php $form = ActiveForm::begin(); ?>

<?

$id_zakaznika = Yii::$app->request->get('id');

///////////////////////////////////// OA ///////////////////////////////////////

// Skupina
	$zp = ZakaznikySkupina::find()->all(); 
	$listData=ArrayHelper::map($zp,'id','name');	

	$skupina = $form->field($model, 'zakazniky_skupina_id')->widget(Select2::classname(), [
		'data' => $listData,
		'options' => [
				'placeholder' => '--- Vyberte ---',
				'multiple' => false,
				'class'=>'hide',
				'value' => $skupina,
			],
			'pluginOptions' => [
				'allowClear' => true
			],
	]); 
	
	// O Zeme
	$cn = Countries::find()->all(); 
	$cnListData=ArrayHelper::map($cn,'id','name');	
	
	if($id_zakaznika > 0)
	{
		$ozeme = $form->field($model, 'o_countries_id')->widget(Select2::classname(), [
			'data' => $cnListData,
			'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class'=>'hide',
					//'value' => 1
				],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	}
	else
	{
		$ozeme = $form->field($model, 'o_countries_id')->widget(Select2::classname(), [
			'data' => $cnListData,
			'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class'=>'hide',
					//'value' => 1
				],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	}	
	
	$oname = $form->field($model, 'o_name')->textInput(['maxlength' => true]);
	$oulice = $form->field($model, 'o_ulice')->textInput(['maxlength' => true]);
	$omesto = $form->field($model, 'o_mesto')->textInput(['maxlength' => true]);
    $opsc = $form->field($model, 'o_psc')->textInput(['maxlength' => true]);
	
	$id_zakaznika_field = Html::hiddenInput('id_zakaznika_field', $id_zakaznika, ['id'=> 'id_zakaznika_field']);
	$ico = $form->field($model, 'ico')->textInput(['maxlength' => true, 'class' => 'form-control']);

    $dic = $form->field($model, 'dic')->textInput(['maxlength' => true]);
	$spolehlivy_platce_dph = $form->field($model, 'spolehlivy_platce_dph')->textInput(['maxlength' => true, 'readonly' => true]);
	$spolehlivy_platce_dph_button = Html::tag('div', 'Ověření', ['class'=>'btn btn-success', 'id'=>'btn_platce', 'style'=>'margin-top: 24px;']);
	
	$ico_button = Html::tag('div', 'Ověření IČ v ARES', ['class'=>'btn btn-success', 'id'=>'ares', 'style'=>'margin-top: 24px;']);
	
$oa = ""
	. "$id_zakaznika_field"
	. "<span class='form-group field-modely required col-xs-2'>$ico</span>"
	. "<span class='form-group field-modely required col-xs-2'>$ico_button</span>"	
	. "<span class='form-group field-modely required col-xs-2'>$dic</span>"
	. "<span class='form-group field-modely required col-xs-1'>$spolehlivy_platce_dph</span>"
	. "<span class='form-group field-modely required col-xs-1'>$spolehlivy_platce_dph_button</span>"
	. "<span class='form-group field-modely required col-xs-4'>$skupina</span>"
	. "<span class='form-group field-modely required col-xs-12'>$oname</span>"
	. "<span class='form-group field-modely required col-xs-12'>$oulice</span>"
	. "<span class='form-group field-modely required col-xs-6'>$omesto</span>"
	. "<span class='form-group field-modely required col-xs-3'>$opsc</span>"
	. "<span class='form-group field-modely required col-xs-3'>$ozeme</span>"
;

///////////////////////////////////// FA ///////////////////////////////////////

	//$fstatus = $form->field($model, 'is_fa')->widget(CheckboxX::classname(), ['pluginOptions'=>['threeState'=>false]]);
	
	$fstatus = $form->field($model, 'is_fa')->checkbox(['style' => 'margin: 10px;']);

	if($id_zakaznika > 0)
	{
		$fzeme = $form->field($model, 'f_countries_id')->widget(Select2::classname(), [
			'data' => $cnListData,
			'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class'=>'hide'
				],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	}
	else
	{
		$fzeme = $form->field($model, 'f_countries_id')->widget(Select2::classname(), [
			'data' => $cnListData,
			'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class'=>'hide',
					'value' => 1
				],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	}
	
	$fname = $form->field($model, 'f_name')->textInput(['maxlength' => true]);
	$fulice = $form->field($model, 'f_ulice')->textInput(['maxlength' => true]);
	$fmesto = $form->field($model, 'f_mesto')->textInput(['maxlength' => true]);
    $fpsc = $form->field($model, 'f_psc')->textInput(['maxlength' => true]);
	
	$fa_button = Html::tag('div', 'Fakturační a obchodní adresa jsou shodné', ['class'=>'btn btn-success', 'id'=>'f-shodne', 'style'=>'margin-top: 24px;']);
	
	if($model->is_fa == '1')
	{
		$show = "";
	}	
	else
	{
		$show = "style='display: none;'";
	}
	
$fa = ""
	. "<div class='form-group field-modely required col-xs-12' style='font-size: 14px;'>$fstatus</div>"
	. "<div id='fa_div' $show ><div class='form-group field-modely required col-xs-6'>$fname</div>"
	. "<div class='form-group field-modely required col-xs-3'>$fulice</div>"
	. "<div class='form-group field-modely required col-xs-3'>$fa_button</div>"	
	. "<div class='form-group field-modely required col-xs-6'>$fmesto</div>"
	. "<div class='form-group field-modely required col-xs-3'>$fpsc</div>"
	. "<div class='form-group field-modely required col-xs-3'>$fzeme</div></div>";

///////////////////////////////////// DA ///////////////////////////////////////
	
	$pstatus = $form->field($model, 'is_pa')->checkbox(['style' => 'margin: 10px;']);
	
	if($id_zakaznika > 0)
	{
		$pzeme = $form->field($model, 'p_countries_id')->widget(Select2::classname(), [
			'data' => $cnListData,
			'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class'=>'hide'
				],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	}
	else
	{
		$pzeme = $form->field($model, 'p_countries_id')->widget(Select2::classname(), [
			'data' => $cnListData,
			'options' => [
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class'=>'hide',
					'value' => 1
				],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	}
	
	$pname = $form->field($model, 'p_name')->textInput(['maxlength' => true]);
	$pulice = $form->field($model, 'p_ulice')->textInput(['maxlength' => true]);
	$pmesto = $form->field($model, 'p_mesto')->textInput(['maxlength' => true]);
    $ppsc = $form->field($model, 'p_psc')->textInput(['maxlength' => true]);
	
	$pa_button = Html::tag('div', 'Obchodní a adresa provozovny jsou shodné', ['class'=>'btn btn-success', 'id'=>'p-shodne', 'style'=>'margin-top: 24px;']);
	
	if($model->is_pa == '1')
	{
		$show2 = "";
	}	
	else
	{
		$show2 = "style='display: none;'";
	}
	
$da = ""
	. "<div class='form-group field-modely required col-xs-12' style='font-size: 14px;'>$pstatus</div>"
	. "<div id='pa_div' $show2 ><div class='form-group field-modely required col-xs-6'>$pname</div>"
	. "<div class='form-group field-modely required col-xs-3'>$pulice</div>"
	. "<div class='form-group field-modely required col-xs-3'>$pa_button</div>"	
	. "<div class='form-group field-modely required col-xs-6'>$pmesto</div>"
	. "<div class='form-group field-modely required col-xs-3'>$ppsc</div>"
	. "<div class='form-group field-modely required col-xs-3'>$pzeme</div></div>";

///////////////////////////////////// SP ///////////////////////////////////////

	
	$ko = $form->field($model, 'kontaktni_osoba')->textInput(['maxlength' => true]);
	$tel = $form->field($model, 'phone')->textInput(['maxlength' => true]);
	$mobil = $form->field($model, 'mobil')->textInput(['maxlength' => true]);
	$web = $form->field($model, 'web')->textInput(['maxlength' => true]);
	$email = $form->field($model, 'email')->textInput(['maxlength' => true]);
	/*
	$email = $form->field($model, 'email', [
        'addon' => ['prepend' => ['content'=>'@']]
    ]);
	 * 
	 */
$sp = ""
	. "<div class='form-group field-modely required col-xs-9'>$ko</div>"
	. "<div class='form-group field-modely required col-xs-3'>$email</div>"	
	. "<div class='form-group field-modely required col-xs-4'>$tel</div>"
	. "<div class='form-group field-modely required col-xs-4'>$mobil</div>"
	. "<div class='form-group field-modely required col-xs-4'>$web</div>"
;


///////////////////////////////////// PDB //////////////////////////////////////

$klice = Klice::find()->all();
foreach($klice as $kl)
{
	$data[] = [$kl['id'] => $kl['name']];
}

$list = Select2::widget([
    'name' => 'a-klice',
    'value' => json_decode($model->klice), // initial value
    'data' => $data,
    'maintainOrder' => true,
    'options' => ['placeholder' => '', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 15
    ],
]);

$poznamka = $form->field($model, 'poznamka')->textarea(['rows' => '6']);

$pdb = ""
	. "<label class='form-group field-modely required col-xs-12'>Adresní klíče</label>"
	. "<div class='form-group field-modely required col-xs-12'>$list</div>"
	. "<div class='form-group field-modely required col-xs-12'>$poznamka</div>"
;

///////////////////////////////////// OB ///////////////////////////////////////


$splatnost = $form->field($model, 'splatnost')->textInput(['maxlength' => true]);

$c_hladina = CenovaHladina::find()->all();
foreach($c_hladina as $ch)
{
	$c_data[] = [$ch['id'] => $ch['name']];
}

$c_list = Select2::widget([
    'name' => 'c-hladina',
    'value' => json_decode($model->c_hladina), // initial value
    'data' => $c_data,
    'maintainOrder' => true,
    'options' => ['placeholder' => '', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 15
    ],
]);

if (Yii::$app->controller->action->id == 'create')
{
	$value = 0;
}
else
{
	$value = json_decode($model->ceniky);
}
$ceniky = Ceniky::find()->all();
foreach($ceniky as $cn)
{
	$ceniky_data[] = [$cn['id'] => $cn['name']];
}

$ceniky_list = Select2::widget([
    'name' => 'ceniky',
    'value' => $value, // initial value
    'data' => $ceniky_data,
    'maintainOrder' => true,
    'options' => ['placeholder' => '', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 15
    ],
]);


$ob = ""
	. "<div class='form-group field-modely required col-xs-2'>$splatnost</div>"
	. "<label class='field-modely required col-xs-5'>Cenová hladina</label>"
	. "<label class='field-modely required col-xs-5'>Ceniky</label>"
	. "<div class='form-group field-modely required col-xs-5'>$c_list</div>"
	. "<div class='form-group field-modely required col-xs-5'>$ceniky_list</div>"	
;

?>
	
	
	<div class="tabs">
    <ul class="tab-links">
        <li class="active">
			<a href="#tab1">Obchodní adresa</a>
		</li>
		<li><a href="#tab11">Fakturační adresa</a></li>
        <li><a href="#tab2">Adresa provozovny</a></li>
        <li><a href="#tab3">Spojení</a></li>
        <li><a href="#tab4">Podrobnosti</a></li>
		<li><a href="#tab5">Obchod</a></li>
    </ul>
 
    <div class="tab-content col-xs-12" style="min-height: 400px;">
		
        <div id="tab1" class="tab active">
            <?=$oa?>
        </div>
		
		 <div id="tab11" class="tab">
            <?=$fa?>
        </div>
 
        <div id="tab2" class="tab">
			<?=$da?>
	    </div>
 
        <div id="tab3" class="tab">
            <?=$sp?>
        </div>
 
        <div id="tab4" class="tab">
            <?=$pdb?>
        </div>
		
		<div id="tab5" class="tab">
            <?=$ob?>
			
	
			

			
			
			
			
        </div>
    </div>
</div>
	
	
	
	
	
	<? $model->datetime = date('Y-m-d H:i:s'); ?>
    <?= $form->field($model, 'datetime')->hiddenInput()->label(false) ?>

    <div class="form-group" style="margin-left: 25px;"> 
        <?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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

$category = new Category();
$category->fullTree(0,0);
	
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
				'attribute' => 'name',
				'contentOptions' => ['style' => 'min-width:400px;'],
				'format' => 'raw',
                'value' => function($data){
					return Html::a(Html::encode($data->name), '#', ['class' => 'vybrat-item', 
																	'data-id' => $data->id, 
																	'data-popis' => $data->name, 
																	'data-plu' => $data->kod,
																]);
                },
			],
            'kod',
            [
				'label'=>'Vybrat',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(Html::encode("Vybrat"), '#', ['class' => 'vybrat-item', 
																	'data-id' => $data->id, 
																	'data-popis' => $data->name, 
																	'data-plu' => $data->kod,
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


Modal::begin([
    'options' => [
        'id' => 'modal-view2',
		'size' => Modal::SIZE_DEFAULT,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_DEFAULT,
    'header' => '<h4 style="margin:0; padding:0" id="modal-view-header">Pozor! Už máte firmu z takovým IČO</h4>',
    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
]);

	
		
echo '<div id="main-show-view">
	<h2 id="znac-firma" style="text-align: center"></h2>
	<div id="znac-select" style="display: none;"></div>
	<div class="form-group field-seznam-cena_s_dph required">
		<button class="btn btn-success btn-100" type="submit" id="submit_go_ico"  style="margin-top: 22px; width: 50%; margin-left: 25%;" >Jít na stranku firmy</button>
	</div>
</div>';

Modal::end();

?>
	
	
	
	
	
	
	
	
	
	
	
</div>
