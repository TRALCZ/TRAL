<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\XmlImport;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $model app\models\XmlImport */

$this->title = "Přidané položky importu č." . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Xml Imports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="xml-import-view">
	
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

	<p>
		<?
		$xmlImport = XmlImport::findOne($model->id);
		
		$orders_for_check = unserialize($xmlImport->result);
		$orders_errors = unserialize($xmlImport->errors);
		
		if($xmlImport->errors)
		{
			foreach($orders_errors as $oe)
			{
				echo "<span style='color:red'>" . $oe . "</span><br>";
			}
		}
		
		if($xmlImport->result)
		{	
			// echo '<br><br><b>Prosím, zkontrolujte položky</b>';
			echo "<div class='row'>";
			foreach ($orders_for_check as $key => $order)
			{
				$k = $key + 1;
				echo "<div class='col-md-3'><strong style='color: #3C8DBC;'>Položka $k:</strong><br>";
				foreach ($order as $name => $val)
				{
					echo "<strong>{$name}:</strong>&nbsp;&nbsp;&nbsp; {$val} {$merge_array[$name][$val]}<br>";
				}
				echo "<br><br></div>";
				/*
				echo "<br><b>Položka $k:</b><table>";
				foreach ($order as $name => $val)
				{
					echo "<tr><td> $name </td><td> $val </td><td>".$merge_array[$name][$val]."</td></tr>";
				}
				echo '</table>';
				*/
			}
			echo "</div>";
		}
		?>
		<br><br>
		<?= Html::a('Zpět', ['/xml-import'], ['class'=>'btn btn-success', 'style'=>'width:150px;']) ?>
		
	</p>

</div>
