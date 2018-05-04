<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\models\ZakaznikySkupina;
use yii\bootstrap\Modal;

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ZakaznikySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Firmy';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakazniky-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<!--
    <p>
        <?= Html::a('Přidat zákazníka', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	-->
	<div style="float: left; width: 30%;">
        <div id="dialog_skupiny" class="btn btn-success">Přidat zákazníka</div>
    </div>
	
	<div style="float: right; width: 30%; text-align: right;">
        <div id="zakazniky_de" class="btn btn-warning">Stahnout zákazníky z webu dvere-erkado.cz</div>
    </div>
	
<? 
	$zakaznikySkupina = new ZakaznikySkupina();
	$zakaznikySkupina->fullTree(0,0); //Category::ShowTree(0, 0); 
?>	

<?php Pjax::begin(['id' => 'boxPajax',

    'timeout' => false,
    'clientOptions' => ['id' => '1']

]); ?>   

	<?php

		$gridColumnsExport = [
			'id',
            'o_name',
            'phone',
            'email:email',
            'ico',
            'dic',
            'kontaktni_osoba',
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
        //    ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'id',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
            'o_name',
            'phone',
            'email:email',
            'ico',
            'dic',
            'kontaktni_osoba',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width:5%;'],
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width:5%;'],
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

</td>
  </tr>

</table> 

</div>

<?php

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

	$ml = ZakaznikySkupina::find()->all();
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
		<button class="btn btn-success btn-100" type="submit" id="submit_vybrat_zakazniky_skupina"  style="margin-top: 22px; width: 50%; margin-left: 20%;" >Vybrat</button>
	</div>
</div>';

Modal::end();


?>