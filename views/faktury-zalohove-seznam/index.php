<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FakturyZalohoveSeznamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Faktury Zalohove Seznams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktury-zalohove-seznam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Faktury Zalohove Seznam'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'faktury_zalohove_id',
            'seznam_id',
            'pocet',
            'cena',
            // 'typ_ceny',
            // 'sazba_dph',
            // 'sleva',
            // 'celkem',
            // 'celkem_dph',
            // 'vcetne_dph',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
