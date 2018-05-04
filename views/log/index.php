<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logy');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <? //echo Html::a(Yii::t('app', 'Create Log'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'controller_name',
            [
				'attribute' => 'user_id',
				'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->asArray()->all(), 'id', 'name'), ['class'=>'form-control','prompt' => '']),
				'value' => 'user.name',
				'contentOptions' => ['style' => 'min-width: 20%;'],
			],
            'message:ntext',
			'item_id',
            'datetime',
			//['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
