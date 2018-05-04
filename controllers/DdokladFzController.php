<?php

namespace app\controllers;

use Yii;
use app\models\DdokladFz;
use app\models\DdokladFzSearch;
use app\models\FakturyZalohove;
use app\models\Zakazniky;
use app\models\Ucty;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Log;
use app\models\Countries;
use kartik\mpdf\Pdf;

/**
 * PdokladFzController implements the CRUD actions for PdokladFz model.
 */
class DdokladFzController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all PdokladFz models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new DdokladFzSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andFilterWhere(['smazat' => '0']);
		$dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single PdokladFz model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
				'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new PdokladFz model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new DdokladFz();

		// Faktury zalohove
		$fz = array();
		$fz['id'] = Yii::$app->request->get('fz');

		$faktura_zalohova = FakturyZalohove::findOne($fz['id']);

		$fz['cislo'] = $faktura_zalohova->cislo;
		$fz['zakaznik'] = Zakazniky::getName($faktura_zalohova->zakazniky_id);
		$fz['celkem'] = $faktura_zalohova->celkem;
		$fz['celkem_dph'] = $faktura_zalohova->celkem_dph;

		if ($model->load(Yii::$app->request->post()))
		{
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$save = $model->save();
			
			$celkem = $model->celkem;
			$celkem_dph = $model->celkem_dph;
			$dph = floatval($celkem_dph - $celkem);
			
			if ($save)
			{
				// 324
				$u324 = Ucty::find()->where(['name' => '324'])->one();
				$suma324 = $u324->suma;
				$u324->suma = floatval($suma324 - $celkem_dph);
				$u324->update();
				
				// 343
				$u343 = Ucty::find()->where(['name' => '343'])->one();
				$suma343 = $u343->suma;
				$u343->suma = floatval($suma343 + $dph);
				$u343->update();
				
				// cislo
				$cislo = "DDFZ-" . $model->id;
				$nb = DdokladFz::findOne($model->id);
				$nb->cislo = $cislo;
				$nb->update();

				// Log
				$addLog = Log::addLog("Přidal daňový doklad", $model->id);
				Yii::$app->session->setFlash('success', "Daňový doklad přidan úspěšně");
			}

			return $this->redirect(['index']);
		} 
		else
		{
			return $this->render('create', [
					'model' => $model,
					'fz' => $fz,
			]);
		}
	}

	/**
	 * Updates an existing PdokladFz model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		// Faktury zalohove
		$fz = array();
		$fz['id'] = $model->faktury_zalohove_id;

		$faktura_zalohova = FakturyZalohove::findOne($fz['id']);

		$fz['cislo'] = $faktura_zalohova->cislo;
		$fz['zakaznik'] = Zakazniky::getName($faktura_zalohova->zakazniky_id);
		$fz['celkem'] = $faktura_zalohova->celkem;
		$fz['celkem_dph'] = $faktura_zalohova->celkem_dph;
		
		if ($model->load(Yii::$app->request->post()))
		{
			$ddoklad = DdokladFz::findOne($id);
			$old_celkem = $ddoklad->celkem;
			$old_celkem_dph = $ddoklad->celkem_dph;
			$old_dph = floatval($old_celkem_dph - $old_celkem);
			
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			
			$save = $model->save();
			
			if ($save)
			{
				$celkem = $model->celkem;
				$celkem_dph = $model->celkem_dph;
				$dph = floatval($celkem_dph - $celkem);
				
				// 324
				$u324 = Ucty::find()->where(['name' => '324'])->one();
				$suma324 = $u324->suma;
				$new_suma = floatval($suma324 + $old_celkem_dph);
				$u324->suma = floatval($new_suma - $celkem_dph);
				$u324->update();
				
				// Ucet 343
				$u343 = Ucty::find()->where(['name' => '343'])->one();
				$suma343 = $u343->suma;
				$new_suma = floatval($suma343 - $old_dph);
				$u343->suma = floatval($new_suma + $dph);
				$u343->update();
				
				// Log
				$addLog = Log::addLog("Opravil bankovní doklad", $model->id);
				Yii::$app->session->setFlash('success', "Bankovní doklad opraven úspěšně");
			}
			return $this->redirect(['index']);
		} else
		{
			return $this->render('update', [
					'model' => $model,
					'fz' => $fz,
			]);
		}
	}

	/**
	 * Deletes an existing PdokladFz model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		// $this->findModel($id)->delete();
		// Delete
		$nb = DdokladFz::findOne($id);
		$celkem = $nb->celkem;
		$nb->smazat = 1;
		$nb->update();
		
		// 211
		$u211 = Ucty::find()->where(['name' => '211'])->one(); // 211
		$suma = $u211->suma;
		$u211->suma = floatval($suma - $celkem);
		$u211->update();
		
		// 324
		$u324 = Ucty::find()->where(['name' => '324'])->one();
		$suma = $u324->suma;
		$u324->suma = floatval($suma - $celkem);
		$u324->update();
		
		// Log
		$addLog = Log::addLog("Smazal bankovní doklad", $id);
		Yii::$app->session->setFlash('success', "Bankovní doklad smazan úspěšně");
		
		//$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the PdokladFz model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return PdokladFz the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = DdokladFz::findOne($id)) !== null)
		{
			return $model;
		} else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionPrint($id)
	{
		$ddoklad = DdokladFz::findOne($id);
		$zakazniky = Zakazniky::findOne($nabidky->zakazniky_id);
		$countries_f = Countries::findOne($zakazniky->f_countries_id);
		$countries_d = Countries::findOne($zakazniky->d_countries_id);
		//$nabidky_seznam = FakturyZalohoveSeznam::find()->where(['faktury_zalohove_id' => $id])->all();

		$content = $this->renderPartial('template-pdf', [
			'id' => $nabidky->id,
			'cislo' => $nabidky->cislo,
			'vystaveno' => date('d.m.Y', strtotime($nabidky->vystaveno)),
			'platnost' => date('d.m.Y', strtotime($nabidky->platnost)),
			'zname' => $zakazniky->name,
			'zico' => $zakazniky->ico,
			'zdic' => $zakazniky->dic,
			'zfulice' => $zakazniky->f_ulice,
			'zfpsc' => $zakazniky->f_psc,
			'zfmesto' => $zakazniky->f_mesto,
			'zfzeme' => $countries_f->name,
			'zdulice' => $zakazniky->d_ulice,
			'zdpsc' => $zakazniky->d_psc,
			'zdmesto' => $zakazniky->d_mesto,
			'zdzeme' => $countries_d->name,
			'zphone' => $zakazniky->phone,
			'zmobil' => $zakazniky->mobil,
			'zemail' => $zakazniky->email,
			'nabidky_seznam' => $nabidky_seznam,
		]);
		$pdf = new Pdf([
			'mode' => Pdf::MODE_UTF8,
			'format' => Pdf::FORMAT_A4,
			'orientation' => Pdf::ORIENT_PORTRAIT,
			'destination' => Pdf::DEST_DOWNLOAD,
			'marginHeader' => 5,
			'marginFooter' => 3,
			'marginTop' => 22,
			'marginRight' => 12,
			'marginLeft' => 12,
			'marginBottom' => 10,
			'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			'cssInline' => '.title_pdf{font-size:7px}',
			'options' => ['title' => 'ERKADO'],
			'methods' => [
				'SetHeader' => ['

<table class="title_pdf">
  <tr>
    <th>ERKADO CZ s.r.o.</th>
    <th>IČ: 27909590</th>
    <th>DIČ: CZ27909590</th>
	<th colspan="2" style="font-weight: normal; font-size: 10px;">Sídlo společností: Krausova 604, Letňany, Praha 22, 19900</th>
  </tr>
  <tr>
	  <td><img src="https://dvere-erkado.cz/img/logo.png" width="135"/></td>
    <td valign="top">
		<b>CENTRÁLA-SKLAD</b><br> 
		Průběžná 1548/90, Strašnice<br> 
		Praha 10, 10000<br>
		tel.: 244 460 824, 722 265 123<br> 
		e-mail: info@erkado.cz
	</td>
    <td valign="top">
		<b>POBOČKA PRAHA 6</b><br> 
		Bělohorská 161/279, Břevnov<br>
		Praha 6, 16900<br>
		tel.: 283 980 500<br>
		e-mail: praha6@erkado.cz
	</td>
	<td valign="top">
		<b>POBOČKA BRNO</b><br>
		Cejl 109, Zábrdovice<br>
		Brno, 60200<br>
		tel.: 545 222 111<br>
		e-mail: brno@erkado.cz
	</td>
	<td valign="top">
		<b>E-SHOP:</b><br>
		www.erkado.cz<br>
		www.dvere-erkado.cz
	</td>
  </tr>
</table>

					'],
				'SetFooter' => ['<div style="font-size: 9px; font-weight: normal; margin-top: 7px; font-style: normal; "><div style="float: left; width: 50%;  text-align: left;">Společnost je vedená u rejstříkového soudu v Praze - oddíl C, vložka 125808</div><div style="float: left; width: 5%; text-align: right;">{PAGENO} / {nb}</div><div style="float: left; width: 45%; text-align: right;">Zpracováno systémem ERKADO. Vytiskl(a): ' . Yii::$app->user->identity->name . '</div></div>'],
			],
			'filename' => "Danovy-doklad-{$id}.pdf",
			'content' => $content,
		]);

		return $pdf->render();
	}

}
