<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use app\models\Seznam;
use app\models\Odstin;
use app\models\Rada;
use app\models\Norma;
use app\models\Rozmer;
use app\models\Druh;
use app\models\Ventilace;
use app\models\Otevirani;
use app\models\Typzamku;
use app\models\Vypln;
use app\models\Ceniky;
use app\models\Sklady;
use app\models\Zakazniky;
use app\models\Jednotka;
use app\models\Priplatek;
use app\models\PriplatekOptions;
use app\models\CenikySeznam;

use yii\helpers\Url;
//use kartik\widgets\DepDrop;
use kartik\depdrop\DepDrop;

//use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $model app\models\Seznam */
/* @var $form yii\widgets\ActiveForm */

$seznam = new Seznam();
if (Yii::$app->controller->action->id == 'create')
{
	$typ_id = Yii::$app->request->get('id');
	$update_id = Yii::$app->request->get('id');
}
else
{
	$typ = Seznam::find()->where(['id'=>Yii::$app->request->get('id')])->one();
	$typ_id = $typ['typ_id'];

	$update_id = Yii::$app->request->get('id');
}

?>

<div class="typ-form">

	<?php $form = ActiveForm::begin(); ?>
	
	<!-- Interiérové dveře -->
		
		<? if ($typ_id == 1): // Interiérové dveře ?>	
		
		<div id="autocreate_catalog" style="background-color: #d7e4f4; min-height: 230px; margin-bottom: 50px;" class='form-group field-modely required col-xs-12'>
			
			<div class='form-group field-modely required col-xs-12'>
				<?= $form->field($model, 'typ_id')->hiddenInput(['value' => $typ_id, 'maxlength' => true, 'readonly' => true, 'id' => 'typ1'])->label(false) ?>
			</div>

			<?
				$ml = Norma::find()->all();
				$listData1 = ArrayHelper::map($ml, 'id', 'name');
				
				if ($model->norma_id)
				{
					$norma_id = $model->norma_id;
				} else
				{
					$norma_id = 1;
				}
			?>
	
			<div class='form-group field-modely required col-xs-3'>
				<?
					echo $form->field($model, 'norma_id')->widget(Select2::classname(), [
						'data' => $listData1,
						'options' => [
							'id' => 'norma1',
							'value' => $norma_id,
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
				$ml = Rada::find()->all();
				$listData1 = ArrayHelper::map($ml, 'id', 'name');
			?>

			<div class='form-group field-modely required col-xs-3'>
				<?
					echo $form->field($model, 'rada_id')->widget(Select2::classname(), [
						'data' => $listData1,
						'options' => [
							'id' => 'rada1',
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
				if ($model->modely_id)
				{
					$modely_id = $model->modely_id;
				}
				else
				{
					$modely_id = 0;
				}
				
				if ($update_id > 0)
				{
					$seznam = Seznam::findOne($update_id);
					$selected_id = $seznam['modely_id'];
					
					$odstin = Odstin::findOne($selected_id);
					$selected_name = $odstin['name'];
					
					$selected = array($selected_id => $selected_name);
				}
			?>

			<div class='form-group field-modely required col-xs-3'>
				<?
					echo $form->field($model, 'modely_id')->widget(DepDrop::classname(), [
						'name' => 'modely_id',
						'type' => DepDrop::TYPE_SELECT2,
						'data' => $selected,
						//'data' => [2 => 'Tablets'],
						'options' => [
							'id' => 'model1',
							//'data'=>[2 => 'Tablets'],
							'placeholder' => '--- Vyberte ---',
							'multiple' => false,
							'class' => 'hide',
						],
						'select2Options' => [
							'pluginOptions' => ['allowClear' => true]
						],
						'pluginOptions' => [
							'allowClear' => true,
							'initialize' => true,
							'depends' => ['rada1'],
							'placeholder' => '--- Vyberte ---',
							'url' => Url::to(['/site/modely']),
						],
					]);
				?>

			</div>

			<?
				if ($model->odstin_id)
				{
					$odstin_id = $model->odstin_id;
				}
				else
				{
					$odstin_id = 0;
				}
				
				if ($update_id > 0)
				{
					$seznam = Seznam::findOne($update_id);
					$selected_id = $seznam['odstin_id'];
					
					$odstin = Odstin::findOne($selected_id);
					$selected_name = $odstin['name'];
					
					$selected = array($selected_id => $selected_name);
				}
			?>

			<div class='form-group field-modely required col-xs-3'>
				<?
					echo $form->field($model, 'odstin_id')->widget(DepDrop::classname(), [
						'name' => 'odstin_id',
						'type' => DepDrop::TYPE_SELECT2,
						'data' => $selected,
						//'data' => [2 => 'Tablets'],
						'options' => [
							'id' => 'odstin1',
							//'data'=>[2 => 'Tablets'],
							'placeholder' => '--- Vyberte ---',
							'multiple' => false,
							'class' => 'hide',
						],
						'select2Options' => [
							'pluginOptions' => ['allowClear' => true]
						],
						'pluginOptions' => [
							'allowClear' => true,
							'initialize' => true,
							'depends' => ['model1'],
							'placeholder' => '--- Vyberte ---',
							'url' => Url::to(['/site/odstiny']),
						],
					]);
				?>
				

			</div>
			
			<?
				$ml = Rozmer::find()->all();
				$listData1 = $seznam->selectWithCena($ml);
				//$listData1 = ArrayHelper::map($ml, 'id', 'name');
				
				
			?>

			<div class='form-group field-modely required col-xs-3'>
				<?
					echo $form->field($model, 'rozmer_id')->widget(Select2::classname(), [
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
				?>
			</div>
			
			<?
				$ml = Otevirani::find()->all();
				$listData1 = ArrayHelper::map($ml, 'id', 'name');
			?>

			<div class='form-group field-modely required col-xs-2'>
				<?
					echo $form->field($model, 'otevirani_id')->widget(Select2::classname(), [
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
				?>
			</div>
			
			<?
				$ml = Typzamku::find()->all();
				$listData1 = ArrayHelper::map($ml, 'id', 'name');
			?>

			<div class='form-group field-modely required col-xs-2'>
				<?
					echo $form->field($model, 'typzamku_id')->widget(Select2::classname(), [
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
				?>
			</div>
			
			<?
				$ml = Ventilace::find()->all();
				//$priplatek_options = PriplatekOptions::find()->where(['priplatek_id' => $pl->id])->all();
				//$listData1 = ArrayHelper::map($ml, 'id', 'name');
				$listData1 = $seznam->selectWithCena($ml);
				
				if (Yii::$app->controller->action->id == 'create')
				{
					$ventilace_id = 1;
				} 
				else
				{
					$ventilace_id = $model->ventilace_id;
				}
			?>

			<div class='form-group field-modely required col-xs-3'>
				<?
					echo $form->field($model, 'ventilace_id')->widget(Select2::classname(), [
						'data' => $listData1,
						'options' => [
							'id' => 'ventilace1',
							'value' => $ventilace_id,
							'data-zkratka' => '',
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
				$ml = Vypln::find()->all();
				//$listData1 = ArrayHelper::map($ml, 'id', 'name');
				$listData1 = $seznam->selectWithCena($ml);
				
				if (Yii::$app->controller->action->id == 'create')
				{
					$vypln_id = 1;
				} 
				else
				{
					$vypln_id = $model->vypln_id;
				}
			?>

			<div class='form-group field-modely required col-xs-2' id="vypln1_div" <? if ($model->rada_id <> 1):?> style="display: none;"<? endif; ?> >
				<?
					echo $form->field($model, 'vypln_id')->widget(Select2::classname(), [
						'data' => $listData1,
						'options' => [
							'id' => 'vypln1',
							'value' => $vypln_id,
							'data-zkratka' => '',
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
				
				$priplatek = Priplatek::find()->all();
				
				$i = 0;
				
				if (Yii::$app->controller->action->id == 'create')
				{
					//$ventilace_id = 1;
					$priplatekid = 0;
				} 
				else
				{
					$priplatekid = json_decode($model->priplatek_options_id);
				}
				
				foreach ($priplatek as $pl)
				{
					$priplatek_options = PriplatekOptions::find()->where(['priplatek_id' => $pl->id])->all();
					//$listData1 = ArrayHelper::map($priplatek_options, 'id', 'name');
					$listData1 = $seznam->selectWithCena($priplatek_options);
					
					if(isset($priplatekid[$i]))
					{
						$prp = $priplatekid[$i];
					}
					else
					{
						$prp = 0;
					}
					
					echo "<div class='form-group field-modely required col-xs-3'>";
						echo '<label class="control-label">' . $pl->name . '</label>';
						echo Select2::widget([
								'name' => 'priplatek_options_id' . $i,
								'hideSearch' => false,
								'data' => $listData1,
								'options' => [
												'placeholder' => '--- Vyberte ---', 
												'id' => 'prplt' . $i, 
												'data-prop' => $i
											],
								'value' => $prp,
								'pluginOptions' => [
									'allowClear' => true,
							],
						]);
					echo "</div>";	
					$i++;
				}
			?>
			
			<?= Html::hiddenInput('celkem-priplatek', $i, ['maxlength' => true, 'class' => 'form-control', 'id' => 'cpl']) ?>
			
			
			
		</div>
	
		<? elseif ($typ_id == 2): ?>	
			
			<div class='form-group field-modely required col-xs-12'>
				<?= $form->field($model, 'typ_id')->hiddenInput(['value' => $typ_id, 'maxlength' => true, 'readonly' => true, 'id' => 'typ1'])->label(false) ?>
			</div>
	
		<? endif; ?>		
	<!-- // Interiérové dveře -->
	
	
	
	
    <div class='form-group field-modely required col-xs-6'>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	
	
	<div class='form-group field-modely required col-xs-2'>
		<?
		if (Yii::$app->controller->action->id == 'create')
		{
			$cena = '';
		} 
		else
		{
			$cs = CenikySeznam::find()->where(['seznam_id' => $update_id])->one();
			$cena = $cs->cena;
		}
		?>
		<?= Html::label('Cena bez DPH') ?>
		<?= Html::textInput('cena_bez_dph', $cena, ['maxlength' => true, 'class' => 'form-control', 'id' => 'seznam-cena_bez_dph']) ?>
	</div>
	
	
	<?
		$ml = Jednotka::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');
		
		if (Yii::$app->controller->action->id == 'create')
		{
			$jednotka_id = 1;
		} 
		else
		{
			$jednotka_id = $model->jednotka_id;
		}
	?>

	<div class='form-group field-modely required col-xs-2'>
		<?
			echo $form->field($model, 'jednotka_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'jednotka1',
					'value' => $jednotka_id,
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
		$ml = Druh::find()->all();
		$listData1 = ArrayHelper::map($ml, 'id', 'name');
		
		if (Yii::$app->controller->action->id == 'create')
		{
			if ($typ_id == 2)
			{
				$druh_id = 2;
			}
			else
			{
				$druh_id = 1;
			}
		} 
		else
		{
			$druh_id = $model->druh_id;
		}
	?>

	<div class='form-group field-modely required col-xs-2'>
		<?
			echo $form->field($model, 'druh_id')->widget(Select2::classname(), [
				'data' => $listData1,
				'options' => [
					'id' => 'druh1',
					'value' => $druh_id,
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
	
	<div class='form-group field-modely required col-xs-2'>
		<?= $form->field($model, 'carovy_kod')->textInput(['maxlength' => true, 'id' => 'carovykod1']); ?>
	</div>
	
	<div class='form-group field-modely required col-xs-2'>

		<?
			$ml = Ceniky::find()->all();
			$listData1 = ArrayHelper::map($ml, 'id', 'name');
			
			if (Yii::$app->controller->action->id == 'create')
			{
				$ceniky_id = 1;
			} 
			else
			{
				$cs = \app\models\CenikySeznam::find()->where(['seznam_id' => $update_id])->one();
				$ceniky_id = $cs->ceniky_id;
			}

			echo Html::label('Ceniky');

			echo Select2::widget([
				'name' => 'ceniky_id',
				'data' => $listData1,
				'value' => $ceniky_id,
				'options' => [
					'id' => 'ceniky_id',
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
	
	<div class='form-group field-modely required col-xs-2'>
		<?
			$ml = Sklady::find()->all();
			$listData1 = ArrayHelper::map($ml, 'id', 'name');

			echo Html::label('Sklady');

			echo Select2::widget([
				'name' => 'sklady_id',
				'data' => $listData1,
				'value' => 1,
				'options' => [
					'id' => 'sklady_id',
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
	
	<div class='form-group field-modely required col-xs-2'>
		<?
			
			if (Yii::$app->controller->action->id == 'create')
			{
				$dodavat = '';
			} 
			else
			{
				$dodavatele = Zakazniky::findOne($model->zakazniky_id);
			
				if ($dodavatele->o_name)
				{
					$dodavat = $dodavatele->o_name;
				}
				else
				{
					$dodavat = '';
				}
			}
		
		?>
		<?= Html::label('Dodavatele') ?>
		<?= Html::textInput('dodavatele', $dodavat, ['maxlength' => true, 'class' => 'form-control', 'readonly' => true, 'id' => 'seznam-dodavatele']) ?>
		<?= $form->field($model, 'zakazniky_id')->hiddenInput()->label(false) ?>
	</div>
	
	
	<!--
	<div class='form-group field-modely required col-xs-2'>
		<?
			/*
			$ml = Zakazniky::find()->where(['zakazniky_skupina_id' => '2'])->all();
			$listData1 = ArrayHelper::map($ml, 'id', 'o_name');

			echo Html::label('Dodavatel');

			echo Select2::widget([
				'name' => 'zakazniky_id',
				'data' => $listData1,
				'value' => 89,
				'options' => [
					'id' => 'zakazniky_id',
					'placeholder' => '--- Vyberte ---',
					'multiple' => false,
					'class' => 'hide'
				],
				'pluginOptions' => [
					'allowClear' => true
				],
			]);
			 * 
			 */
		?>


	</div>
	-->
	<?
		if (Yii::$app->controller->action->id == 'create')
		{
			$hmotnost = 0;
		} 
		else
		{
			$hmotnost = $model->hmotnost;
		}
	?>
	
	<div class='form-group field-modely required col-xs-2'>
		<?= $form->field($model, 'hmotnost')->textInput(['maxlength' => true, 'id' => 'hmotnost1', 'value' => $hmotnost]); ?>
	</div>
	
	<?
		if (Yii::$app->controller->action->id == 'create')
		{
			$dodaci_lhuta = 0;
		} 
		else
		{
			$dodaci_lhuta = $model->dodaci_lhuta;
		}
	?>
	
	<div class='form-group field-modely required col-xs-2'>
		<?= $form->field($model, 'dodaci_lhuta')->textInput(['maxlength' => true, 'id' => 'dodaci_lhuta1', 'value' => $dodaci_lhuta]); ?>
	</div>
	
	
	
	
    <div class="form-group field-modely required col-xs-12" style="margin-top: 30px;">
		<?= Html::a('Zpět', ['/seznam/index'], ['class'=>'btn btn-success btn-100']) ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?= Html::submitButton($model->isNewRecord ? 'Přidat' : 'Přidat', ['class' => $model->isNewRecord ? 'btn btn-primary btn-100' : 'btn btn-primary btn-100', 'id'=>'btn_submit']) ?>
			
    </div>

	<?php ActiveForm::end(); ?>

</div>

