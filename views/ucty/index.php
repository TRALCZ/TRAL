<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UctySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Účty');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ucty-index">

<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
	<?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
<?php Pjax::begin(); ?>   
	<?=	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			//['class' => 'yii\grid\SerialColumn'],
			'id',
			'name',
			'suma',
			['class' => 'yii\grid\ActionColumn'],
		],
	]);
	?>
<?php Pjax::end(); ?></div>
