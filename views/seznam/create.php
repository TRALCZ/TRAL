<?php

use yii\helpers\Html;
use app\models\Typ;
use app\models\UserIdentity;

/* @var $this yii\web\View */
/* @var $model app\models\Seznam */

$typ_id = Yii::$app->request->get('id');
$typ = Typ::find()->where(['id'=>$typ_id])->one();
$typ_name = $typ['name'];

	
$this->title = 'Přidat položku (' . $typ_name . ')';
$this->params['breadcrumbs'][] = ['label' => 'Seznam', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seznam-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
