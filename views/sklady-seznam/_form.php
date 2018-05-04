<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;

use app\models\Sklady;
use app\models\CenikySeznam;
use app\models\SeznamSearch;
use app\models\Category;
use app\models\Seznam;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\CenikySeznam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sklady-seznam-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?
		$ml = Sklady::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');

		if ($model->sklady_id)
		{
			$sklady_id = $model->sklady_id;
		} 
		else
		{
			$sklady_id = 1;
		}
	?>

	<div class='form-group field-modely required col-xs-4'>
		<?
			echo $form->field($model, 'sklady_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'sklady1',
					'value' => $sklady_id,
					'data-zkratka' => 'CZ',
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
	
	<div style="float: left; width: 100%; height: 0px;">&nbsp;</div>
	
	<?
		if ($model->seznam_id)
		{
			$seznam = Seznam::findOne($model->seznam_id);
			$name = $seznam->name;
		} 
		else
		{
			$name = '';
		}
	?>
	
	<div class='form-group field-modely required col-xs-6'>
		<?= Html::label('Název') ?>
		<?= Html::textInput('name', $name, ['maxlength' => true, 'class' => 'form-control', 'id' => 'skladyseznam-name', 'readonly' => true]) ?>
	</div>
	
	<?= $form->field($model, 'seznam_id')->hiddenInput(['maxlength' => true])->label(false) ?>
	
	<div class='form-group field-modely required col-xs-3' id="select_katalog" style="margin: 25px 0 30px 0;">
		<button type="button" class="btn btn-warning show_modal">Vybrat</button>
	</div>
	
	
	<?
		if ($model->zasoba_pojistna)
		{
			$zasoba_pojistna = $model->zasoba_pojistna;
		} 
		else
		{
			$zasoba_pojistna = 0;
		}
	?>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'zasoba_pojistna')->textInput(['value' => $zasoba_pojistna]) ?>
	</div>
	
	<!--
	<div class='form-group field-modely required col-xs-4'>
		<?//= $form->field($model, 'cena')->textInput(['maxlength' => true]) ?>
	</div>
	-->
    
	<?
		if ($model->stav_zasoby)
		{
			$stav_zasoby = $model->stav_zasoby;
		} 
		else
		{
			$stav_zasoby = 0;
		}
	?>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'stav_zasoby')->textInput(['value' => $stav_zasoby]) ?>
	</div>
	
	
	<?
		if ($model->objednano)
		{
			$objednano = $model->objednano;
		} 
		else
		{
			$objednano = 0;
		}
	?>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'objednano')->textInput(['value' => $objednano]) ?>
	</div>
	
	
	<?
		if ($model->rezervace)
		{
			$rezervace = $model->rezervace;
		} 
		else
		{
			$rezervace = 0;
		}
	?>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'rezervace')->textInput(['value' => $rezervace]) ?>
	</div>
	
	
	<?
		if ($model->predpokladny_stav)
		{
			$predpokladny_stav = $model->predpokladny_stav;
		} 
		else
		{
			$predpokladny_stav = 0;
		}
	?>
	
	<div class='form-group field-modely required col-xs-3'>
		<?= $form->field($model, 'predpokladny_stav')->textInput(['value' => $predpokladny_stav]) ?>
	</div>
	
	
    <div class="form-group field-modely required col-xs-12" style="margin-top: 30px;">
		<?= Html::a('Zpět', ['/sklady-seznam/index'], ['class'=>'btn btn-success btn-100']) ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', 'id'=>'btn_submit']) ?>
    </div>
	

    <?php ActiveForm::end(); ?>
	
	<?
	$searchModel = new SeznamSearch();
	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	// Modal

	Modal::begin([
    'options' => [
        'id' => 'boxSkladySeznam',
		'size' => Modal::SIZE_LARGE,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_LARGE,
    'header' => '<h4 style="margin:0; padding:0">Vyberte položku z katalogu (Interiérové dveře)</h4>',
    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
]);

		$category = new Category();
		$category->fullTree(0, 0);

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
					'attribute' => 'name',
					'contentOptions' => ['style' => 'min-width:400px;'],
					'format' => 'raw',
					'value' => function($data) {
						$cs = CenikySeznam::find()->where(['seznam_id' => $data->id])->one();
						return Html::a(Html::encode($data->name), '#', ['class' => 'vybrat-dvere',
								'data-id' => $data->id,
								'data-name' => $data->name,
								'data-kod' => $data->kod,
								'data-cena' => $cs['cena'],
								//'data-is_cenova_hladina' => 'Ne',
						]);
					},
				],
				'kod',
				[
					'attribute' => 'cena',
					'format' => 'raw',
					'value'=>function($data) {
						$cs = CenikySeznam::find()->where(['seznam_id' => $data->id])->one();
						return $cs['cena'];
					},
				],		
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

</div>
