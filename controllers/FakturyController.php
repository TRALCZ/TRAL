<?php

namespace app\controllers;

use Yii;
use app\models\Faktury;
use app\models\FakturySearch;
use app\models\FakturySeznam;
use app\models\Nabidky;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Seznam;
use app\models\Zakazniky;
use app\models\Countries;
use kartik\mpdf\Pdf;
use app\models\Log;
use app\models\Ucty;

/**
 * FakturyController implements the CRUD actions for Faktury model.
 */
class FakturyController extends Controller
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
     * Lists all Faktury models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FakturySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andFilterWhere(['smazat' => '0']);
		$dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faktury model.
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
     * Creates a new Faktury model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Faktury();
		
		// Nabidky
		$nab = array();
		$nab['id'] = Yii::$app->request->get('idn');
		
		if($nab['id'] > 0)
		{
			$nabidky = Nabidky::findOne($nab['id']);
			$nab['popis'] = $nabidky->popis;
			$nab['vystaveno'] = $nabidky->vystaveno;
			$nab['platnost'] = $nabidky->platnost;
			$nab['zpusoby_platby_id'] = $nabidky->zpusoby_platby_id;
			$nab['zakazniky_id'] = $nabidky->zakazniky_id;
		}
		
        if ($model->load(Yii::$app->request->post())) 
		{
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$model->platnost = date('Y-m-d', strtotime($model->platnost));
			
			$zaloha = $model->zaloha;
			$zaloha_dph = $model->zaloha_dph;
			$zdph = floatval($zaloha_dph - $zaloha);
			
			if (!$model->nabidky_id)
			{
				$model->nabidky_id = 0;
			}
			
			$save = $model->save();
			
			// cislo
			$cislo = "FV-" . $model->id;
			$nb = Faktury::findOne($model->id);
			$nb->cislo = $cislo;
			$nb->update();
			
			$faktury_id = $model->id;
			$count_polozka = Yii::$app->request->post('count_polozka');	

			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);

				$pocet = Yii::$app->request->post('pocet' . $i); 
				$cena = Yii::$app->request->post('cena' . $i); 
				$typ_ceny = Yii::$app->request->post('typ_ceny' . $i);;
				$sazba_dph = Yii::$app->request->post('sazba_dph' . $i);
				$sleva = Yii::$app->request->post('sleva' . $i);
				$celkem = Yii::$app->request->post('celkem' . $i);
				$celkem_dph = Yii::$app->request->post('celkem_dph' . $i);
				$vcetne_dph = Yii::$app->request->post('vcetne_dph' . $i);
				
				if ($seznam_id > 0 && $faktury_id > 0)
				{
					$fakturySeznam = FakturySeznam::addFakturySeznam($faktury_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
				
				/*
				// Rezervace
				$sz = Seznam::find()->where(['id' => $seznam_id])->one();
				$objednano_old = $sz['objednano']; 
				$objednano_new = intval($objednano_old + $pocet);

				$seznam = Seznam::findOne($seznam_id);
				$seznam->objednano = $objednano_new;
				$seznam->update();
				 * 
				 */
				
				if ($seznam_id > 0)
				{
					// Rezervace
					$sz = Seznam::findOne($seznam_id);
					$stav_old = $sz['stav'];
					$rezerva_old = $sz['rezerva']; 

					$stav_new = intval($stav_old - $pocet);
					$rezerva_new = intval($rezerva_old - $pocet);

					$sz->stav = $stav_new;
					$sz->rezerva = $rezerva_new;
					$sz->update();
				}
				
			}
			
			if($nab['id'] > 0)
			{
				// nabidky
				$nabidky = Nabidky::findOne($nab['id']);
				$nabidky->faktura_vydana = 1;
				$nabidky->status_id = 4;
				$nabidky->update();
			}
			
			if($save)
			{
				$celkem_dph = FakturySeznam::find()->where(['faktury_id' => $model->id])->sum('vcetne_dph');
				$celkem = FakturySeznam::find()->where(['faktury_id' => $model->id])->sum('celkem');
				$dph = floatval($celkem_dph - $celkem);
				
				$celkem_zbozi = FakturySeznam::find()->leftJoin('seznam', 'seznam.id = faktury_seznam.seznam_id')->where(['faktury_seznam.faktury_id' => $model->id])->andWhere(['seznam.druh_id' => '1'])->sum('faktury_seznam.celkem');
				$celkem_sluzby = FakturySeznam::find()->leftJoin('seznam', 'seznam.id = faktury_seznam.seznam_id')->where(['faktury_seznam.faktury_id' => $model->id])->andWhere(['seznam.druh_id' => '2'])->sum('faktury_seznam.celkem');

				// 311
				$u311 = Ucty::find()->where(['name' => '311'])->one();
				$suma311 = $u311->suma;
				$u311->suma = floatval($suma311 + $celkem_dph);
				$u311->update();
				
				// 343
				$u343 = Ucty::find()->where(['name' => '343'])->one();
				$suma343 = $u343->suma;
				$u343->suma = floatval($suma343 + $dph);
				$u343->update();
				
				
				// 604 zbozi (druh_id = 1)
				$u604 = Ucty::find()->where(['name' => '604'])->one();
				$suma604 = $u604->suma;
				$u604->suma = floatval($suma604 + $celkem_zbozi);
				$u604->update();
				
				// 602 sluzby (druh_id = 2)
				$u602 = Ucty::find()->where(['name' => '602'])->one();
				$suma602 = $u602->suma;
				$u602->suma = floatval($suma602 + $celkem_sluzby);
				$u602->update();
				
				// Zaloha
				// 324
				$u324 = Ucty::find()->where(['name' => '324'])->one();
				$suma324 = $u324->suma;
				$u324->suma = floatval($suma324 - $zaloha_dph);
				$u324->update();
				
				// 311
				$u311 = Ucty::find()->where(['name' => '311'])->one();
				$suma311 = $u311->suma;
				$u311->suma = floatval($suma311 - $zaloha);
				$u311->update();
				
				// 343
				$u343 = Ucty::find()->where(['name' => '343'])->one();
				$suma343 = $u343->suma;
				$u343->suma = floatval($suma343 - $zdph);
				$u343->update();
				
				// 311
				$u311 = Ucty::find()->where(['name' => '311'])->one();
				$suma311 = $u311->suma;
				$u311->suma = floatval($suma311 - $zdph);
				$u311->update();
				
				// Log
				$addLog = Log::addLog("Přidal fakturu", $model->id);
				Yii::$app->session->setFlash('success', "Faktura přidana úspěšně");
			
			}
			
			
			/*
			for($ii=1; $ii< 5000;$ii++)
			{
				$faktury = new Faktury;
				$faktury->nabidky_id = 1;
				$faktury->cislo = 'FV-' . $ii;
				$faktury->popis = 'Popis ' . $ii; 
				$faktury->zpusoby_platby_id = 2;
				$faktury->zakazniky_id = 1;
				$faktury->user_id = 1;
				$faktury->vystaveno = '2017-10-16';
				$faktury->platnost = '2017-11-06';
				$faktury->datetime_add = '2017-10-16 16:58:35';
				$faktury->smazat = 0;
				$faktury->insert();	
				
				$id = Yii::$app->db->getLastInsertID();
					
				$fakturySeznam1 = FakturySeznam::addFakturySeznam($id, 1, 2, '2500.00', 'bez_dph', 21, '0.00', '1656.00', '347.76', '2003.76');
				$fakturySeznam2 = FakturySeznam::addFakturySeznam($id, 2, 5, '2500.00', 'bez_dph', 21, '0.00', '3312.00', '695.52', '4007.52');
			}
			*/
			
			
			

            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } 
		else
		{
            return $this->render('create', [
                'model' => $model,
				'nab' => $nab,
            ]);
        }
    }

    /**
     * Updates an existing Faktury model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()))
		{
			$faktury = Faktury::findOne($id);
			$old_celkem = $faktury->celkem;
			$old_celkem_dph = $faktury->celkem_dph;
			$old_dph = floatval($old_celkem_dph - $old_celkem);
			
			$old_zaloha = $faktury->zaloha;
			$old_zaloha_dph = $faktury->zaloha_dph;
			$old_zdph = floatval($old_zaloha_dph - $old_zaloha);
			
			$old_celkem_zbozi = FakturySeznam::find()->leftJoin('seznam', 'seznam.id = faktury_seznam.seznam_id')->where(['faktury_seznam.faktury_id' => $id])->andWhere(['seznam.druh_id' => '1'])->sum('faktury_seznam.celkem');
			$old_celkem_sluzby = FakturySeznam::find()->leftJoin('seznam', 'seznam.id = faktury_seznam.seznam_id')->where(['faktury_seznam.faktury_id' => $id])->andWhere(['seznam.druh_id' => '2'])->sum('faktury_seznam.celkem');
				
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$model->platnost = date('Y-m-d', strtotime($model->platnost));
			
			$save = $model->save();
			
			$faktury_id = $id;
			
			$all_celkem_old = 0;
			
			$nab = Faktury::find()->where(['id' => $id])->one();
			$nabidky_id = $nab['nabidky_id'];

			$nbs = FakturySeznam::find()->where(['faktury_id' => $faktury_id])->all();
			foreach($nbs as $nb)
			{
				$all_celkem_old = $all_celkem_old + $nb['celkem'];
				
				$seznam_id = $nb['seznam_id'];
				$pocet = $nb['pocet'];
				
				/*
				// Rezervace delete
				if ($seznam_id > 0)
				{
					if($nabidky_id > 0)
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$rezerva_old = $sz['rezerva'];

						$objednano_new = intval($objednano_old - $pocet);
						$rezerva_new = intval($rezerva_old - $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->rezerva = $rezerva_new;
						$seznam->update();
					}
					else
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$objednano_new = intval($objednano_old - $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->update();
					}
				}
				 * 
				 */
			}
			
			$deleteOS = FakturySeznam::deleteFakturySeznam($faktury_id);
			
			//print_r(Yii::$app->request->post());
			//exit();
			
			$all_celkem_new = 0;
			
			$count_polozka = Yii::$app->request->post('count_polozka');	
			
			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);
				$pocet = Yii::$app->request->post('pocet' . $i);
				$cena = Yii::$app->request->post('cena' . $i); 
				$typ_ceny = Yii::$app->request->post('typ_ceny' . $i);;
				$sazba_dph = Yii::$app->request->post('sazba_dph' . $i);
				$sleva = Yii::$app->request->post('sleva' . $i);
				$celkem = Yii::$app->request->post('celkem' . $i);
				$celkem_dph = Yii::$app->request->post('celkem_dph' . $i);
				$vcetne_dph = Yii::$app->request->post('vcetne_dph' . $i);
				
				$all_celkem_new = $all_celkem_new + $celkem;
				
				if ($seznam_id > 0 && $faktury_id > 0)
				{
					$fakturySeznam = FakturySeznam::addFakturySeznam($faktury_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
				
				/*
				// Rezervace add
				if ($seznam_id > 0)
				{
					if($nabidky_id > 0)
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$rezerva_old = $sz['rezerva'];

						$objednano_new = intval($objednano_old + $pocet);
						$rezerva_new = intval($rezerva_old + $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->rezerva = $rezerva_new;
						$seznam->update();
					}
					else
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$objednano_new = intval($objednano_old + $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->update();
					}
				}
				 * 
				 */
			}
			
			if($save)
			{
				$celkem_dph = FakturySeznam::find()->where(['faktury_id' => $model->id])->sum('vcetne_dph');
				$celkem = FakturySeznam::find()->where(['faktury_id' => $model->id])->sum('celkem');
				$dph = floatval($celkem_dph - $celkem);
				
				$celkem_zbozi = FakturySeznam::find()->leftJoin('seznam', 'seznam.id = faktury_seznam.seznam_id')->where(['faktury_seznam.faktury_id' => $model->id])->andWhere(['seznam.druh_id' => '1'])->sum('faktury_seznam.celkem');
				$celkem_sluzby = FakturySeznam::find()->leftJoin('seznam', 'seznam.id = faktury_seznam.seznam_id')->where(['faktury_seznam.faktury_id' => $model->id])->andWhere(['seznam.druh_id' => '2'])->sum('faktury_seznam.celkem');
				
				// 311
				$u311 = Ucty::find()->where(['name' => '311'])->one();
				$suma311 = $u311->suma;
				$new_suma311 = floatval($suma311 - $old_celkem_dph);
				$u311->suma = floatval($new_suma311 + $celkem_dph);
				$u311->update();
				
			
				// 343
				$u343 = Ucty::find()->where(['name' => '343'])->one();
				$suma343 = $u343->suma;
				$new_suma343 = floatval($suma343 - $old_dph);
				$u343->suma = floatval($new_suma343 + $dph);
				$u343->update();
				
				
				// 604 zbozi (druh_id = 1)
				$u604 = Ucty::find()->where(['name' => '604'])->one();
				$suma604 = $u604->suma;
				$new_suma604 = floatval($suma604 - $old_celkem_zbozi);
				$u604->suma = floatval($new_suma604 + $celkem_zbozi);
				$u604->update();
				
				// 602 sluzby (druh_id = 2)
				$u602 = Ucty::find()->where(['name' => '602'])->one();
				$suma602 = $u602->suma;
				$new_suma602 = floatval($suma602 - $old_celkem_sluzby);
				$u602->suma = floatval($new_suma602 + $celkem_sluzby);
				$u602->update();
				
				// Zaloha
				// 324
				$u324 = Ucty::find()->where(['name' => '324'])->one();
				$suma324 = $u324->suma;
				$new_suma324 = floatval($suma324 + $old_zaloha_dph);
				$u324->suma = floatval($new_suma324 - $zaloha_dph);
				$u324->update();
				
				// 311
				$u311 = Ucty::find()->where(['name' => '311'])->one();
				$suma311 = $u311->suma;
				$new_suma311 = floatval($suma311 + $old_zaloha);
				$u311->suma = floatval($new_suma311 - $zaloha);
				$u311->update();
				
				// 343
				$u343 = Ucty::find()->where(['name' => '343'])->one();
				$suma343 = $u343->suma;
				$new_suma343 = floatval($suma343 + $old_zdph);
				$u343->suma = floatval($new_suma343 - $zdph);
				$u343->update();
				
				// 311
				$u311 = Ucty::find()->where(['name' => '311'])->one();
				$suma311 = $u311->suma;
				$new_suma311 = floatval($suma311 + $old_zdph);
				$u311->suma = floatval($new_suma311 - $zdph);
				$u311->update();
				
				
				// Log
				$addLog = Log::addLog("Opravil fakturu. Stará suma = {$all_celkem_old} Kč, nová suma = {$all_celkem_new} Kč", $id);
				Yii::$app->session->setFlash('success', "Faktura opravená úspěšně");
			}
			
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } 
		else
		{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Faktury model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // Delete
		$nb = Faktury::findOne($id);
		$nb->smazat = 1;
		$nb->update();
		
		// Log
		$addLog = Log::addLog("Smazal fakturu", $id);
		
		//$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Faktury model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faktury the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faktury::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionPrint($id)
	{
		$faktury = Faktury::findOne($id);
		$zakazniky = Zakazniky::findOne($faktury->zakazniky_id);
		$countries_f = Countries::findOne($zakazniky->f_countries_id);
		$countries_d = Countries::findOne($zakazniky->d_countries_id);
		$faktury_seznam = FakturySeznam::find()->where(['faktury_id' => $id])->all();

		$content = $this->renderPartial('template-pdf', [
			'id' => $faktury->id,
			'cislo' => $faktury->cislo,
			'vystaveno' => date('d.m.Y', strtotime($faktury->vystaveno)),
			'platnost' => date('d.m.Y', strtotime($faktury->platnost)),
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
			'faktury_seznam' => $faktury_seznam,
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
			'filename' => "Faktura-{$id}.pdf",
			'content' => $content,
		]);

		return $pdf->render();
	}
}
