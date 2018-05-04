<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Skladové skupiny');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'id',
				'options' => ['width' => '70px']
			],
            'name',
			'zkratka',
			'poznamka',
            [
				'attribute' => 'tree',
				'label' => 'Root',
				'filter' => Category::find()->roots()->select('name, id')->indexBy('id')->column(),
				'value' => function($model)
				{
					if( ! $model->isRoot())
					{
						return $model->parents()->one()->name;
					}
					return "No Parent";
				}
				
			],
			//'parent.name',
            //'lft',
            //'rgt',
            // 'lvl',
            'position',
            // 'created_at',
            // 'updated_at',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width:50px;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width:50px;'],
			],
        ],
    ]); ?>
	
<?php Pjax::end(); ?></div>
