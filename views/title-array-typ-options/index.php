<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\TitleArrayTyp;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TitleArrayTypOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Title Array Typ Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-array-typ-options-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Přidat'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'title_array_typ_id',
			[
				'attribute' => 'title_array_typ_id',
				'filter' => Html::activeDropDownList($searchModel, 'title_array_typ_id', ArrayHelper::map(TitleArrayTyp::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'title_array_typ.name',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
            'name',
            'znac',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'contentOptions' => ['style' => 'min-width: 5%;'],
			],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
