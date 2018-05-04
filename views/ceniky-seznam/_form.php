<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\models\Ceniky;
use app\models\Typceny;
use app\models\SeznamSearch;
use app\models\Category;
use app\models\CenikySeznam;
use app\models\Seznam;

/* @var $this yii\web\View */
/* @var $model app\models\CenikySeznam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ceniky-seznam-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?
		if (Yii::$app->controller->action->id == 'create')
		{
			$name = '';
		} 
		else
		{
			$all_name = Seznam::findOne($model->seznam_id);
			$name = $all_name->name;
		}
	?>
	
	
	<div class='form-group field-modely required col-xs-8'>		
		<?= Html::label('Název') ?>
		<?= Html::textInput('name', $name, ['maxlength' => true, 'class' => 'form-control', 'id' => 'cenikyseznam-name', 'readonly' => true]) ?>
		<?//= $form->field($model, 'name')->textInput(['readonly' => 'readonly']) ?>
	</div>

	
	
	<div class='form-group field-modely required col-xs-4' id="select_katalog" style="margin: 25px 0 30px 0;">
		<button type="button" class="btn btn-warning show_modal">Vybrat</button>
	</div>
	
	
	<div class='form-group field-modely required col-xs-4'>
		<?= $form->field($model, 'cena')->textInput(['maxlength' => true]) ?>
	</div>

    <?
		$ml = Typceny::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');

		if ($model->typceny_id)
		{
			$typceny_id = $model->typceny_id;
		} 
		else
		{
			$typceny_id = 1;
		}
	?>

	<div class='form-group field-modely required col-xs-4'>
		<?
			echo $form->field($model, 'typceny_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'typceny1',
					'value' => $typceny_id,
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
	
	<?
		$ml = Ceniky::find()->all();
		$listDataC = ArrayHelper::map($ml, 'id', 'name');

		if ($model->ceniky_id)
		{
			$ceniky_id = $model->ceniky_id;
		} 
		else
		{
			$ceniky_id = 1;
		}
	?>

	<div class='form-group field-modely required col-xs-4'>
		<?
			echo $form->field($model, 'ceniky_id')->widget(Select2::classname(), [
				'data' => $listDataC,
				'options' => [
					'id' => 'ceniky1',
					'value' => $ceniky_id,
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
	
	<?= $form->field($model, 'seznam_id')->hiddenInput(['maxlength' => true])->label(false) ?>
	
	<div class="form-group field-modely required col-xs-12" style="margin-top: 30px;">
		<?= Html::a('Zpět', ['/ceniky-seznam/index'], ['class'=>'btn btn-success btn-100']) ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Opravit', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', id=>'btn_submit']) ?>
    </div>
	
	
    <?php ActiveForm::end(); ?>
	
	<?
	$searchModel = new SeznamSearch();
	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	// Modal

	Modal::begin([
    'options' => [
        'id' => 'boxCenikySeznam',
		'size' => Modal::SIZE_LARGE,
		'tabindex' => false // important for Select2 to work properly
    ],
	'size' => Modal::SIZE_LARGE,
    'header' => '<h4 style="margin:0; padding:0">Vyberte položku (Interiérové dveře)</h4>',
    //'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
]);

		Category::fullTree(0, 0);

		Pjax::begin([
			'id' => 'boxPajax',
			'timeout' => false,
			'clientOptions' => ['id' => '1']
		]);
		?>
		<!--
		<div class='form-group field-modely required col-xs-2' style="float: right;">
			<?
				//$ml = Ceniky::find()->all();
				//$listData1 = ArrayHelper::map($ml, 'id', 'name');
				echo Select2::widget([
					'name' => 'modal-ceniky',
					'data' => $listDataC,
					'options' => ['placeholder' => ''],
					'value' => 1,
					'pluginOptions' => [
						'allowClear' => true
					],
				]);
			?>
		</div>
		-->
		<?
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
								'data-cena' => $cs->cena,
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
				//'min_limit',
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
