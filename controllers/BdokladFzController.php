<?php

namespace app\controllers;

use Yii;
use app\models\BdokladFz;
use app\models\BdokladFzSearch;
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
class BdokladFzController extends Controller
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
		$searchModel = new BdokladFzSearch();
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
		$model = new BdokladFz();

		// Faktury zalohove
		$fz = array();
		$fz['id'] = Yii::$app->request->get('fz');

		$faktura_zalohova = FakturyZalohove::findOne($fz['id']);

		$fz['cislo'] = $faktura_zalohova->cislo;
		$fz['zakaznik'] = Zakazniky::getName($faktura_zalohova->zakazniky_id);
		$fz['celkem_dph'] = $faktura_zalohova->celkem_dph;

		if ($model->load(Yii::$app->request->post()))
		{
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));

			$save = $model->save();
			
			if ($save)
			{
				// 211
				$u211 = Ucty::find()->where(['name' => '211'])->one(); // 211
				$suma211 = $u211->suma;
				$castka = $model->castka;
				$u211->suma = floatval($suma211 + $castka);
				$u211->update();
				
				// 324
				$u324 = Ucty::find()->where(['name' => '324'])->one();
				$suma324 = $u324->suma;
				$castka = $model->castka;
				$u324->suma = floatval($suma324 + $castka);
				$u324->update();
				
				// cislo
				$cislo = "PDFZ-" . $model->id;
				$nb = BdokladFz::findOne($model->id);
				$nb->cislo = $cislo;
				$nb->update();

				// Log
				$addLog = Log::addLog("Přidal bankovní doklad", $model->id);
				Yii::$app->session->setFlash('success', "Bankovní doklad přidan úspěšně");
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
		$fz['celkem_dph'] = $faktura_zalohova->celkem_dph;
		
		if ($model->load(Yii::$app->request->post()))
		{
			$bdoklad = BdokladFz::findOne($id);
			$old_castka = $bdoklad->castka;
			
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			
			$save = $model->save();
			
			if ($save)
			{
				// Ucet 211
				$u211 = Ucty::find()->where(['name' => '211'])->one();
				$suma211 = $u211->suma;
				$new_suma = floatval($suma211 - $old_castka);
				
				$castka = $model->castka;
				$u211->suma = floatval($new_suma + $castka);
				$u211->update();
				
				// 324
				$u324 = Ucty::find()->where(['name' => '324'])->one();
				$suma324 = $u324->suma;
				$new_suma = floatval($suma324 - $old_castka);
				
				$castka = $model->castka;
				$u324->suma = floatval($new_suma + $castka);
				$u324->update();
				
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
		$nb = BdokladFz::findOne($id);
		$castka = $nb->castka;
		$nb->smazat = 1;
		$nb->update();
		
		// 211
		$u211 = Ucty::find()->where(['name' => '211'])->one(); // 211
		$suma = $u211->suma;
		$u211->suma = floatval($suma - $castka);
		$u211->update();
		
		// 324
		$u324 = Ucty::find()->where(['name' => '324'])->one();
		$suma = $u324->suma;
		$u324->suma = floatval($suma - $castka);
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
		if (($model = BdokladFz::findOne($id)) !== null)
		{
			return $model;
		} else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionPrint($id)
	{
		$bdoklad = BdokladFz::findOne($id);
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
			'filename' => "Bankovni-doklad-{$id}.pdf",
			'content' => $content,
		]);

		return $pdf->render();
	}

}
