<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\XmlImportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'XML Import');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xml-import-index">
	
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat XML-soubor'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'file',
            'kosik',
            [
				'attribute' => 'user_id',
				'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'user.name',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
            'datetime',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				'contentOptions' => ['style' => 'min-width:5%;'],
			],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
