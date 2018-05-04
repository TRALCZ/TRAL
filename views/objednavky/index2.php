<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjednavkySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Objednávky vystavené';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="objednavky-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat objednávku'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
<?php Pjax::begin(); ?>    

	<?php

		$gridColumnsExport = [
			'id',
			'user.name',
			'cislo',
			'popis',
			'vystaveno',
			'zakazniky.name',
			'status.name',
			'objednavka_vystavena',
			'faktura_vydana',
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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cislo',
            'popis',
            'zpusoby_platby_id',
            'zakazniky_id',
            // 'user_id',
            // 'vystaveno',
            // 'platnost',
            // 'datetime_add:datetime',
            // 'status_id',
            // 'objednavka_vystavena',
            // 'faktura_vydana',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	
	
<?php Pjax::end(); ?></div>
