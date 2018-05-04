<?php

namespace app\controllers;

use Yii;
use app\models\Objednavky;
use app\models\ObjednavkySeznam;
use app\models\ObjednavkySearch;
use app\models\FakturyPrijate;
use app\models\FakturyPrijateSeznam;
use app\models\DlistPrijaty;
use app\models\DlistPrijatySeznam;
use app\models\Nabidky;
use yii\web\Controller;
use app\models\Seznam;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use app\models\Log;
use app\models\Zakazniky;
use app\models\Countries;
/**
 * ObjednavkyController implements the CRUD actions for Objednavky model.
 */
class ObjednavkyController extends Controller
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
     * Lists all Objednavky models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjednavkySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andFilterWhere(['smazat' => '0']);
		$dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Objednavky model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Objednavky model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	
    public function actionCreate()
    {
        $model = new Objednavky();
		
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
			
			$model->save();
			
			// cislo
			$cislo = "O-" . $model->id;
			$nb = Objednavky::findOne($model->id);
			$nb->cislo = $cislo;
			$nb->update();
			
			$objednavky_id = $model->id;
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
				
				if ($seznam_id > 0 && $objednavky_id > 0)
				{
					$objednavkySeznam = ObjednavkySeznam::addObjednavkaSeznam($objednavky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
				
				if ($seznam_id > 0)
				{
					// Rezervace
					$sz = Seznam::findOne($seznam_id);
					$objednano_old = $sz['objednano'];
					$predpoklad_stav_old = $sz['predpoklad_stav'];

					$objednano_new = intval($objednano_old + $pocet);
					$predpoklad_stav_new = intval($predpoklad_stav_old + $pocet);

					$sz->objednano = $objednano_new;
					$sz->predpoklad_stav = $predpoklad_stav_new;
					$sz->update();
				}
				
			}
			
			if($nab['id'] > 0)
			{
				// nabidky
				$nabidky = Nabidky::findOne($nab['id']);
				$nabidky->objednavka_vystavena = 1;
				$nabidky->status_id = 2; // Objednavka
				$nabidky->update();
			}
			
			// Log
			$addLog = Log::addLog("Přidal objednavku", $model->id);
			Yii::$app->session->setFlash('success', "Objednavka přidana úspěšně");

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
     * Updates an existing Nabidky model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()))
		{
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$model->platnost = date('Y-m-d', strtotime($model->platnost));
			
			$objednavky_id = $id;

			$model->save();
			
			$all_celkem_old = 0;
			$nbs = ObjednavkySeznam::find()->where(['objednavky_id' => $objednavky_id])->all();
			foreach($nbs as $nb)
			{
				$all_celkem_old = $all_celkem_old + $nb['celkem'];
			}
			
			if ($objednavky_id > 0)
			{
				
				foreach($nbs as $nb)
				{
					if($nb['seznam_id'] > 0)
					{
						$seznam_id = $nb['seznam_id'];
						$pocet = $nb['pocet'];	

						$sz = Seznam::findOne($seznam_id);
						$objednano_old = $sz['objednano']; 
						$predpoklad_stav_old = $sz['predpoklad_stav'];

						$objednano_new = intval($objednano_old - $pocet);
						$predpoklad_stav_new = intval($predpoklad_stav_old - $pocet);

						$sz->objednano = $objednano_new;
						$sz->predpoklad_stav = $predpoklad_stav_new;
						$sz->update();
					}
				}	
				
				$deleteNS = ObjednavkySeznam::deleteObjednavkySeznam($objednavky_id);
			}

			
			$all_celkem_new = 0;
			
			$count_polozka = Yii::$app->request->post('count_polozka');	
			
			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);
				$pocet = Yii::$app->request->post('pocet' . $i);
				$prijato = Yii::$app->request->post('prijato' . $i);
				$cena = Yii::$app->request->post('cena' . $i); 
				$typ_ceny = Yii::$app->request->post('typ_ceny' . $i);;
				$sazba_dph = Yii::$app->request->post('sazba_dph' . $i);
				$sleva = Yii::$app->request->post('sleva' . $i);
				$celkem = Yii::$app->request->post('celkem' . $i);
				$celkem_dph = Yii::$app->request->post('celkem_dph' . $i);
				$vcetne_dph = Yii::$app->request->post('vcetne_dph' . $i);
				
				$all_celkem_new = $all_celkem_new + $celkem;
				
				if ($seznam_id > 0 && $objednavky_id > 0)
				{
					// Rezervace
					$sz = Seznam::findOne($seznam_id);
					$objednano_old = $sz['objednano'];
					$predpoklad_stav_old = $sz['predpoklad_stav'];

					$objednano_new = intval($objednano_old + $pocet);
					$predpoklad_stav_new = intval($predpoklad_stav_old + $pocet);

					$sz->objednano = $objednano_new;
					$sz->predpoklad_stav = $predpoklad_stav_new;
					$sz->update();
					
					$objednavkySeznam_id = ObjednavkySeznam::addObjednavkaSeznam($objednavky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph, $prijato);
				}
				
			}
			
			if ($id > 0)
			{
				// Log
				$addLog = Log::addLog("Opravil objednavku. Stara cena (bez DPH) {$all_celkem_old} Kč, nová cena {$all_celkem_new} Kč", $id);
				Yii::$app->session->setFlash('success', "Objednavka opravená úspěšně");
			}
			
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
     * Deletes an existing Objednavky model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
		$nab = Objednavky::find()->where(['id' => $id])->one();
		$nabidky_id = $nab['nabidky_id'];
		
		$objednavky_id = $id;
		
		$nbs = ObjednavkySeznam::find()->where(['objednavky_id' => $objednavky_id])->all();
		foreach($nbs as $nb)
		{
			$seznam_id = $nb['seznam_id'];
			$pocet = $nb['pocet'];

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
		}
		
		// Delete
		$nb = Objednavky::findOne($id);
		$nb->smazat = 1;
		$nb->update();
		
		// Log
		$addLog = Log::addLog("Smazal objednavku", $id);
		Yii::$app->session->setFlash('success', "Objednavka smazaná úspěšně");
		//$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Objednavky model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Objednavky the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Objednavky::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelFakturyPrijate($id)
    {
        if (($model = FakturyPrijate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	/*
	public function actionPrevzit($id) // Prevzit
    {
		$prevzit_id = Yii::$app->request->get('prevzit_id');
		if ($prevzit_id == 1) // Faktura prijata
		{
			return $this->redirect(['../objednavky/update/' . $id .'?faktura_prijata=1']);
		}
		else if($prevzit_id == 2) // Dlist prijaty
		{
			return $this->redirect(['../objednavky/update/' . $id .'?dlist_prijaty=1']);
		}

		return $this->redirect(['../objednavky']);
		
	}
	 * 
	 */
	
	public function actionPrint($id)
	{
		$nabidky = Objednavky::findOne($id);
		$zakazniky = Zakazniky::findOne($nabidky->zakazniky_id);
		$countries_f = Countries::findOne($zakazniky->f_countries_id);
		$countries_d = Countries::findOne($zakazniky->d_countries_id);
		$objednavky_seznam = ObjednavkySeznam::find()->where(['objednavky_id' => $id])->all();
		
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
												'objednavky_seznam' => $objednavky_seznam,
			
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
				'SetHeader'=>['

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
			'filename' => "Objednavka-{$id}.pdf",
			'content' => $content,  	
		]);

		return $pdf->render();
	}
	
}
