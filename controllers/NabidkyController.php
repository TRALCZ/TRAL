<?php

namespace app\controllers;
//namespace yii\bootstrap;

use Yii;
use DOMDocument;
use app\models\Nabidky;
use app\models\NabidkySearch;
use app\models\NabidkySeznam;
use app\models\Seznam;
use app\models\Zakazniky;
use app\models\Countries;
use app\models\Log;
use app\models\UserIdentity;
use app\models\Moneys;
use app\models\ZakaznikySkupina;
use app\models\Jednotka;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

//use yii\bootstrap\Alert;
//use kartik\widgets\Alert;
/**
 * NabidkyController implements the CRUD actions for Nabidky model.
 */
class NabidkyController extends Controller
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
     * Lists all Nabidky models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new NabidkySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andFilterWhere(['smazat' => '0']);
		$dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nabidky model.
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
     * Creates a new Nabidky model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nabidky();
	
        if ($model->load(Yii::$app->request->post())) 
		{
			$model->uuid = Moneys::createID();
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$model->platnost = date('Y-m-d', strtotime($model->platnost));
			
			
			if($model->status_id == NULL)
			{
				$model->status_id = 1;
			}
			
			$model->save();
			
			// cislo
			$cislo = "N-" . $model->id;
			$nb = Nabidky::findOne($model->id);
			$nb->cislo = $cislo;
			$nb->update();
			
			
			
			// NabidkySeznam
			$nabidky_id = $model->id;
			$count_polozka = Yii::$app->request->post('count_polozka');	

			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);

				$pocet = Yii::$app->request->post('pocet' . $i); 
				$cena = Yii::$app->request->post('cena' . $i); 
				$typ_ceny = Yii::$app->request->post('typ_ceny' . $i);
				$sazba_dph = Yii::$app->request->post('sazba_dph' . $i);
				$sleva = Yii::$app->request->post('sleva' . $i);
				$celkem = Yii::$app->request->post('celkem' . $i);
				$celkem_dph = Yii::$app->request->post('celkem_dph' . $i);
				$vcetne_dph = Yii::$app->request->post('vcetne_dph' . $i);
				
				if ($seznam_id > 0 && $nabidky_id > 0)
				{
					$nabidkySeznam = NabidkySeznam::addNabidkaSeznam($nabidky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
			}
			
			// Log
			$addLog = Log::addLog("Přidal nabídku", $model->id);
			Yii::$app->session->setFlash('success', "Nabidka přidana úspěšně");
			
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } 
		else
		{
            return $this->render('create', [
                'model' => $model,
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
			
			$nabidky_id = $id;
			
			$model->save();
			Yii::$app->session->setFlash('success', "Nabidka opravená úspěšně");
			
			// Create XML
			$xml = new DomDocument('1.0', 'utf-8');
				$s5Data = $xml->appendChild($xml->createElement('S5Data'));
					$nabidkaVydanaList = $s5Data->appendChild($xml->createElement('NabidkaVydanaList'));
						$nabidkaVydana = $nabidkaVydanaList->appendChild($xml->createElement('NabidkaVydana'));
							$nabidkaVydana->setAttribute('ID', $model->uuid);

								$celkovaCastka = $nabidkaVydana->appendChild($xml->createElement('CelkovaCastka'));
									$celkovaCastka->appendChild($xml->createTextNode($model->celkem_dph));
								$celkovaCastkaCM = $nabidkaVydana->appendChild($xml->createElement('CelkovaCastkaCM'));
									$celkovaCastkaCM->appendChild($xml->createTextNode($model->celkem_dph));	
									
								$cisloDokladu = $nabidkaVydana->appendChild($xml->createElement('CisloDokladu'));
									$cisloDokladu->appendChild($xml->createTextNode($model->cislo));
								
								$nazev = $nabidkaVydana->appendChild($xml->createElement('Nazev'));
									$nazev->appendChild($xml->createTextNode($model->name));	
								
								
								$zakaznik = Zakazniky::findOne($model->zakazniky_id);
								$country = Countries::findOne($zakaznik->o_countries_id);
								$zakaznikySkupina = ZakaznikySkupina::findOne($zakaznik->zakazniky_skupina_id);
								
								$adresa = $nabidkaVydana->appendChild($xml->createElement('Adresa'));
									$firma = $adresa->appendChild($xml->createElement('Firma'));
										$firma->setAttribute('ID', $zakaznik->uuid);
											$groupF = $firma->appendChild($xml->createElement('Group'));
												$groupF->setAttribute('ID', $zakaznikySkupina->uuid);
									$nazevA = $adresa->appendChild($xml->createElement('Nazev'));
										$nazevA->appendChild($xml->createTextNode($zakaznik->o_name));
									$kontaktniOsobaNazev = $adresa->appendChild($xml->createElement('KontaktniOsobaNazev'));
										$kontaktniOsobaNazev->appendChild($xml->createTextNode($zakaznik->kontaktni_osoba));
									$misto = $adresa->appendChild($xml->createElement('Misto'));
										$misto->appendChild($xml->createTextNode($zakaznik->o_mesto));
									$ulice = $adresa->appendChild($xml->createElement('Ulice'));
										$ulice->appendChild($xml->createTextNode($zakaznik->o_ulice));
									$psc = $adresa->appendChild($xml->createElement('PSC'));
										$psc->appendChild($xml->createTextNode($zakaznik->o_psc));
									$stat = $adresa->appendChild($xml->createElement('Stat'));
										$stat->appendChild($xml->createTextNode($country->name));
								
								if($zakaznik->is_pa == 0) // Stejna PA
								{
									$adresaKoncovehoPrijemce = $nabidkaVydana->appendChild($xml->createElement('AdresaKoncovehoPrijemce'));
									$firmaP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Firma'));
										$firmaP->setAttribute('ID', $zakaznik->uuid);
											$groupFP = $firmaP->appendChild($xml->createElement('Group'));
												$groupFP->setAttribute('ID', $zakaznikySkupina->uuid);
									$nazevAP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Nazev'));
										$nazevAP->appendChild($xml->createTextNode($zakaznik->o_name));
									$kontaktniOsobaNazevP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('KontaktniOsobaNazev'));
										$kontaktniOsobaNazevP->appendChild($xml->createTextNode($zakaznik->kontaktni_osoba));
									$mistoP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Misto'));
										$mistoP->appendChild($xml->createTextNode($zakaznik->o_mesto));
									$uliceP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Ulice'));
										$uliceP->appendChild($xml->createTextNode($zakaznik->o_ulice));
									$pscP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('PSC'));
										$pscP->appendChild($xml->createTextNode($zakaznik->o_psc));
									$statP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Stat'));
										$statP->appendChild($xml->createTextNode($country->name));
									
								}
								else
								{
									$countryP = Countries::findOne($zakaznik->p_countries_id);
									$adresaKoncovehoPrijemce = $nabidkaVydana->appendChild($xml->createElement('AdresaKoncovehoPrijemce'));
										$firmaP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Firma'));
											$firmaP->setAttribute('ID', $zakaznik->uuid);
												$groupFP = $firmaP->appendChild($xml->createElement('Group'));
													$groupFP->setAttribute('ID', $zakaznikySkupina->uuid);
										$nazevAP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Nazev'));
											$nazevA->appendChild($xml->createTextNode($zakaznik->p_name));
										$kontaktniOsobaNazevP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('KontaktniOsobaNazev'));
											$kontaktniOsobaNazevP->appendChild($xml->createTextNode($zakaznik->kontaktni_osoba));
										$mistoP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Misto'));
											$mistoP->appendChild($xml->createTextNode($zakaznik->p_mesto));
										$uliceP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Ulice'));
											$uliceP->appendChild($xml->createTextNode($zakaznik->p_ulice));
										$pscP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('PSC'));
											$pscP->appendChild($xml->createTextNode($zakaznik->p_psc));
										$statP = $adresaKoncovehoPrijemce->appendChild($xml->createElement('Stat'));
											$statP->appendChild($xml->createTextNode($countryP->name));	
								}
								
								if($zakaznik->is_fa == 0) // Stejna PA
								{
									$adresaPrijemceFaktury = $nabidkaVydana->appendChild($xml->createElement('AdresaPrijemceFaktury'));
									$firmaF = $adresaPrijemceFaktury->appendChild($xml->createElement('Firma'));
										$firmaF->setAttribute('ID', $zakaznik->uuid);
											$groupFF = $firmaF->appendChild($xml->createElement('Group'));
												$groupFF->setAttribute('ID', $zakaznikySkupina->uuid);
									$nazevAF = $adresaPrijemceFaktury->appendChild($xml->createElement('Nazev'));
										$nazevAF->appendChild($xml->createTextNode($zakaznik->o_name));
									$kontaktniOsobaNazevF = $adresaPrijemceFaktury->appendChild($xml->createElement('KontaktniOsobaNazev'));
										$kontaktniOsobaNazevF->appendChild($xml->createTextNode($zakaznik->kontaktni_osoba));
									$mistoF = $adresaPrijemceFaktury->appendChild($xml->createElement('Misto'));
										$mistoF->appendChild($xml->createTextNode($zakaznik->o_mesto));
									$uliceF = $adresaPrijemceFaktury->appendChild($xml->createElement('Ulice'));
										$uliceF->appendChild($xml->createTextNode($zakaznik->o_ulice));
									$pscF = $adresaPrijemceFaktury->appendChild($xml->createElement('PSC'));
										$pscF->appendChild($xml->createTextNode($zakaznik->o_psc));
									$statF = $adresaPrijemceFaktury->appendChild($xml->createElement('Stat'));
										$statF->appendChild($xml->createTextNode($country->name));
								}
								else
								{
									$countryF = Countries::findOne($zakaznik->f_countries_id);
									$adresaPrijemceFaktury = $nabidkaVydana->appendChild($xml->createElement('AdresaPrijemceFaktury'));
										$firmaF = $adresaPrijemceFaktury->appendChild($xml->createElement('Firma'));
											$firmaF->setAttribute('ID', $zakaznik->uuid);
												$groupFF = $firmaF->appendChild($xml->createElement('Group'));
													$groupFF->setAttribute('ID', $zakaznikySkupina->uuid);
										$nazevAF = $adresaPrijemceFaktury->appendChild($xml->createElement('Nazev'));
											$nazevAF->appendChild($xml->createTextNode($zakaznik->f_name));
										$kontaktniOsobaNazevF = $adresaPrijemceFaktury->appendChild($xml->createElement('KontaktniOsobaNazev'));
											$kontaktniOsobaNazevF->appendChild($xml->createTextNode($zakaznik->kontaktni_osoba));
										$mistoF = $adresaPrijemceFaktury->appendChild($xml->createElement('Misto'));
											$mistoF->appendChild($xml->createTextNode($zakaznik->f_mesto));
										$uliceF = $adresaPrijemceFaktury->appendChild($xml->createElement('Ulice'));
											$uliceF->appendChild($xml->createTextNode($zakaznik->f_ulice));
										$pscF = $adresaPrijemceFaktury->appendChild($xml->createElement('PSC'));
											$pscF->appendChild($xml->createTextNode($zakaznik->f_psc));
										$statF = $adresaPrijemceFaktury->appendChild($xml->createElement('Stat'));
											$statF->appendChild($xml->createTextNode($countryF->name));		
								}	
								
								$dphAll = $model->celkem_dph - $model->celkem;
								$sumaAll = $nabidkaVydana->appendChild($xml->createElement('Suma'));	
									$celkemAll = $sumaAll->appendChild($xml->createElement('Celkem'));
										$celkemAll->appendChild($xml->createTextNode($model->celkem_dph));
									$celkemCMAll = $sumaAll->appendChild($xml->createElement('CelkemCM'));
										$celkemCMAll->appendChild($xml->createTextNode($model->celkem_dph));	
									$danAll = $sumaAll->appendChild($xml->createElement('Dan'));
										$danAll->appendChild($xml->createTextNode($dphAll));
									$danCMAll = $sumaAll->appendChild($xml->createElement('DanCM'));
										$danCMAll->appendChild($xml->createTextNode($dphAll));
									$zakladAll = $sumaAll->appendChild($xml->createElement('Zaklad'));
										$zakladAll->appendChild($xml->createTextNode($model->celkem));
									$zakladCMAll = $sumaAll->appendChild($xml->createElement('ZakladCM'));
										$zakladCMAll->appendChild($xml->createTextNode($model->celkem));	
			
			
			
			$all_celkem_old = 0;
			$nbs = NabidkySeznam::find()->where(['nabidky_id' => $nabidky_id])->all();
			foreach($nbs as $nb)
			{
				$all_celkem_old = $all_celkem_old + $nb['celkem'];
				
				if($model->status_id == 2) // Objednavka
				{
					$seznam_id = $nb['seznam_id'];
					$pocet = $nb['pocet'];	

					$sz = Seznam::findOne($seznam_id);
					$rezerva_old = $sz['rezerva']; 
					$predpoklad_stav_old = $sz['predpoklad_stav'];

					$rezerva_new = intval($rezerva_old - $pocet);
					$predpoklad_stav_new = intval($predpoklad_stav_old + $pocet);

					$sz->rezerva = $rezerva_new;
					$sz->predpoklad_stav = $predpoklad_stav_new;
					$sz->update();
				}
				
			}
			
			
			if ($nabidky_id > 0)
			{
				$deleteNS = NabidkySeznam::deleteNabidkySeznam($nabidky_id);
			}
			
			$all_celkem_new = 0;
			
			$count_polozka = Yii::$app->request->post('count_polozka');	
			
			if($count_polozka > 0)
			{
				$polozky = $nabidkaVydana->appendChild($xml->createElement('Polozky'));
					$polozky->setAttribute('ObjectType', 'List');
					
			}
			
			
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
				
				if ($seznam_id > 0 && $nabidky_id > 0)
				{
					$nabidkySeznam = NabidkySeznam::addNabidkaSeznam($nabidky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}

				if($model->status_id == 2) // Objednavka
				{
					if($seznam_id > 0)
					{
						$sz = Seznam::findOne($seznam_id);
						$rezerva_old = $sz['rezerva']; 
						$predpoklad_stav_old = $sz['predpoklad_stav'];

						$rezerva_new = intval($rezerva_old + $pocet);
						$predpoklad_stav_new = intval($predpoklad_stav_old - $pocet);

						$sz->rezerva = $rezerva_new;
						$sz->predpoklad_stav = $predpoklad_stav_new;
						$sz->update();
					}
				}
				
				$seznamAll = Seznam::findOne($seznam_id);
				$nSeznam = NabidkySeznam::findOne($nabidkySeznam);
				
				$polozkaNabidkyVydane = $polozky->appendChild($xml->createElement('PolozkaNabidkyVydane'));
					$polozkaNabidkyVydane->setAttribute('ID', $nSeznam->uuid);
					
					$dokladN = $polozkaNabidkyVydane->appendChild($xml->createElement('DokladObjectName'));
						$dokladN->appendChild($xml->createTextNode('NabidkaVydana'));
					
					$typCenyN = $polozkaNabidkyVydane->appendChild($xml->createElement('TypCeny'));
						$typCenyN->setAttribute('EnumValueName', 'BezDane');
							$typCenyN->appendChild($xml->createTextNode(0));
					$typObsahuN = $polozkaNabidkyVydane->appendChild($xml->createElement('TypObsahu'));
						$typObsahuN->setAttribute('EnumValueName', 'BezObsahu');
							$typObsahuN->appendChild($xml->createTextNode(0));		
					$typPolozkyN = $polozkaNabidkyVydane->appendChild($xml->createElement('TypPolozky'));
						$typPolozkyN->setAttribute('EnumValueName', 'Neurcena');
							$typPolozkyN->appendChild($xml->createTextNode(0));	
						
					$nazevN = $polozkaNabidkyVydane->appendChild($xml->createElement('Nazev'));
						$nazevN->appendChild($xml->createTextNode($seznamAll->name));
					
					$celkovaCenaN = $polozkaNabidkyVydane->appendChild($xml->createElement('CelkovaCena'));
						$celkovaCenaN->appendChild($xml->createTextNode($nSeznam->celkem));
					$celkovaCenaCMN = $polozkaNabidkyVydane->appendChild($xml->createElement('CelkovaCenaCM'));
						$celkovaCenaCMN->appendChild($xml->createTextNode($nSeznam->celkem));	
					
					if($nSeznam->sleva <> 0)
					{
						$celkemBezSlevy = number_format((float)(100*($nSeznam->celkem)/(100 - $nSeznam->sleva)), 2, '.', '');
					}
					else
					{
						$celkemBezSlevy = $nSeznam->celkem;
					}
					$celkovaCenaBezSlevy = $polozkaNabidkyVydane->appendChild($xml->createElement('CelkovaCenaBezSlevy'));
						$celkovaCenaBezSlevy->appendChild($xml->createTextNode($celkemBezSlevy));
					$celkovaCenaBezSlevyCM = $polozkaNabidkyVydane->appendChild($xml->createElement('CelkovaCenaBezSlevyCM'));
						$celkovaCenaBezSlevyCM->appendChild($xml->createTextNode($celkemBezSlevy));
				
					$jednCena = $polozkaNabidkyVydane->appendChild($xml->createElement('JednCena'));
						$jednCena->appendChild($xml->createTextNode($nSeznam->cena));
					$jednCenaCM = $polozkaNabidkyVydane->appendChild($xml->createElement('JednCenaCM'));
						$jednCenaCM->appendChild($xml->createTextNode($nSeznam->cena));
						
					$jednotkaAll = Jednotka::findOne($seznamAll->jednotka_id);
					$jednotka = $polozkaNabidkyVydane->appendChild($xml->createElement('Jednotka'));
						$jednotka->appendChild($xml->createTextNode($jednotkaAll->zkratka));
						
					if($nSeznam->sleva <> 0)
					{
						$jednotkovaBezSlevy = number_format((float)(100*($nSeznam->cena)/(100 - $nSeznam->sleva)), 2, '.', '');
					}
					else
					{
						$jednotkovaBezSlevy = $nSeznam->cena;
					}
					$jednotkovaCenaBezSlevy = $polozkaNabidkyVydane->appendChild($xml->createElement('JednotkovaCenaBezSlevy'));
						$jednotkovaCenaBezSlevy->appendChild($xml->createTextNode($jednotkovaBezSlevy));
					$jednotkovaCenaBezSlevyCM = $polozkaNabidkyVydane->appendChild($xml->createElement('JednotkovaCenaBezSlevyCM'));
						$jednotkovaCenaBezSlevyCM->appendChild($xml->createTextNode($jednotkovaBezSlevy));
						
						
					$mnozstvi = $polozkaNabidkyVydane->appendChild($xml->createElement('Mnozstvi'));
						$mnozstvi->appendChild($xml->createTextNode($nSeznam->pocet));	
						
					$dphAll = $polozkaNabidkyVydane->appendChild($xml->createElement('DPH'));	
						$celkem1 = $dphAll->appendChild($xml->createElement('Celkem'));
							$celkem1->appendChild($xml->createTextNode($nSeznam->vcetne_dph));
						$celkem2 = $dphAll->appendChild($xml->createElement('CelkemCM'));
							$celkem2->appendChild($xml->createTextNode($nSeznam->vcetne_dph));
						$dan1 = $dphAll->appendChild($xml->createElement('Dan'));
							$dan1->appendChild($xml->createTextNode($nSeznam->celkem_dph));
						$dan2 = $dphAll->appendChild($xml->createElement('DanCM'));
							$dan2->appendChild($xml->createTextNode($nSeznam->celkem_dph));	
						$sazba1 = $dphAll->appendChild($xml->createElement('Sazba'));
							$sazba1->appendChild($xml->createTextNode($nSeznam->sazba_dph));
						$zaklad1 = $dphAll->appendChild($xml->createElement('Zaklad'));
							$zaklad1->appendChild($xml->createTextNode($nSeznam->celkem));
						$zaklad2 = $dphAll->appendChild($xml->createElement('ZakladCM'));
							$zaklad2->appendChild($xml->createTextNode($nSeznam->celkem));	
						
						
						
						
						
						
				
			}
			
			// DPH 0
			$sumVcetneDph0 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 0])->sum('vcetne_dph');
			if($sumVcetneDph0 > 0)
			{
				$svd0 = $sumVcetneDph0;
			}
			else
			{
				$svd0 = '0.00';
			}

			$sumCelkemDph0 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 0])->sum('celkem_dph');
			if($sumCelkemDph0 > 0)
			{
				$scd0 = $sumCelkemDph0;
			}
			else
			{
				$scd0 = '0.00';
			}

			$sumCelkem0 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 0])->sum('celkem');
			if($sumCelkem0 > 0)
			{
				$sc0 = $sumCelkem0;
			}
			else
			{
				$sc0 = '0.00';
			}

			$dph0 = $nabidkaVydana->appendChild($xml->createElement('DPH0'));
				$celkem0 = $dph0->appendChild($xml->createElement('Celkem'));
					$celkem0->appendChild($xml->createTextNode($svd0));
				$celkemCM0 = $dph0->appendChild($xml->createElement('CelkemCM'));
					$celkemCM0->appendChild($xml->createTextNode($svd0));
				$dan0 = $dph0->appendChild($xml->createElement('Dan'));
					$dan0->appendChild($xml->createTextNode($scd0));
				$danCM0 = $dph0->appendChild($xml->createElement('DanCM'));
					$danCM0->appendChild($xml->createTextNode($scd0));
				$sazba0 = $dph0->appendChild($xml->createElement('Sazba'));
					$sazba0->appendChild($xml->createTextNode('0.00'));	
				$zaklad0 = $dph0->appendChild($xml->createElement('Zaklad'));
					$zaklad0->appendChild($xml->createTextNode($sc0));
				$zakladCM0 = $dph0->appendChild($xml->createElement('ZakladCM'));
					$zakladCM0->appendChild($xml->createTextNode($sc0));

			// DPH 15
			$sumVcetneDph15 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 15])->sum('vcetne_dph');
			if($sumVcetneDph15 > 0)
			{
				$svd15 = $sumVcetneDph15;
			}
			else
			{
				$svd15 = '0.00';
			}

			$sumCelkemDph15 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 15])->sum('celkem_dph');
			if($sumCelkemDph15 > 0)
			{
				$scd15 = $sumCelkemDph15;
			}
			else
			{
				$scd15 = '0.00';
			}

			$sumCelkem15 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 15])->sum('celkem');
			if($sumCelkem15 > 0)
			{
				$sc15 = $sumCelkem15;
			}
			else
			{
				$sc15 = '0.00';
			}

			$dph15 = $nabidkaVydana->appendChild($xml->createElement('DPH1'));
				$celkem15 = $dph15->appendChild($xml->createElement('Celkem'));
					$celkem15->appendChild($xml->createTextNode($svd15));
				$celkemCM15 = $dph15->appendChild($xml->createElement('CelkemCM'));
					$celkemCM15->appendChild($xml->createTextNode($svd15));
				$dan15 = $dph15->appendChild($xml->createElement('Dan'));
					$dan15->appendChild($xml->createTextNode($scd15));
				$danCM15 = $dph15->appendChild($xml->createElement('DanCM'));
					$danCM15->appendChild($xml->createTextNode($scd15));
				$sazba15 = $dph15->appendChild($xml->createElement('Sazba'));
					$sazba15->appendChild($xml->createTextNode('15.00'));	
				$zaklad15 = $dph15->appendChild($xml->createElement('Zaklad'));
					$zaklad15->appendChild($xml->createTextNode($sc15));
				$zakladCM15 = $dph15->appendChild($xml->createElement('ZakladCM'));
					$zakladCM15->appendChild($xml->createTextNode($sc15));		

			// DPH 21
			$sumVcetneDph21 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 21])->sum('vcetne_dph');
			if($sumVcetneDph21 > 0)
			{
				$svd21 = $sumVcetneDph21;
			}
			else
			{
				$svd21 = '0.00';
			}

			$sumCelkemDph21 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 21])->sum('celkem_dph');
			if($sumCelkemDph21 > 0)
			{
				$scd21 = $sumCelkemDph21;
			}
			else
			{
				$scd21 = '0.00';
			}

			$sumCelkem21 = NabidkySeznam::find()->where(['nabidky_id' => $model->id, 'sazba_dph' => 21])->sum('celkem');
			if($sumCelkem21 > 0)
			{
				$sc21 = $sumCelkem21;
			}
			else
			{
				$sc21 = '0.00';
			}

			$dph21 = $nabidkaVydana->appendChild($xml->createElement('DPH2'));
				$celkem21 = $dph21->appendChild($xml->createElement('Celkem'));
					$celkem21->appendChild($xml->createTextNode($svd21));
				$celkemCM21 = $dph21->appendChild($xml->createElement('CelkemCM'));
					$celkemCM21->appendChild($xml->createTextNode($svd21));
				$dan21 = $dph21->appendChild($xml->createElement('Dan'));
					$dan21->appendChild($xml->createTextNode($scd21));
				$danCM21 = $dph21->appendChild($xml->createElement('DanCM'));
					$danCM21->appendChild($xml->createTextNode($scd21));
				$sazba21 = $dph21->appendChild($xml->createElement('Sazba'));
					$sazba21->appendChild($xml->createTextNode('21.00'));	
				$zaklad21 = $dph21->appendChild($xml->createElement('Zaklad'));
					$zaklad21->appendChild($xml->createTextNode($sc21));
				$zakladCM21 = $dph21->appendChild($xml->createElement('ZakladCM'));
					$zakladCM21->appendChild($xml->createTextNode($sc21));
								

			$xml_list = $xml->saveXML();
			//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS

			$xml->formatOutput = true;
			$xml->save('xml/NabidkaVydana-' . $model->id . '.xml');
			
			
			
			
			
			// Log
			$addLog = Log::addLog("Opravil nabidku. Stara cena (bez DPH) {$all_celkem_old} Kč, nová cena {$all_celkem_new} Kč", $id);
			Yii::$app->session->setFlash('success', "Nabidaka opravena úspěšně");
					
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
     * Deletes an existing Nabidky model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $nabidky = Nabidky::find()->where(['id' => $id])->one();
		if($nabidky['status_id'] == 2 && $nabidky['objednavka_vystavena'] == 0) // Objednávka - Objednavka vystavena
		{
			// seznam
			$nseznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();

			foreach($nseznam as $ns)
			{
				$seznam_id = $ns['seznam_id'];
				$pocet = $ns['pocet'];	

				$sz = Seznam::find()->where(['id' => $seznam_id])->one();
				$rezerva_old = $sz['rezerva']; 
				$predpoklad_stav_old = $sz['predpoklad_stav'];

				$rezerva_new = intval($rezerva_old - $pocet);
				$predpoklad_stav_new = intval($predpoklad_stav_old + $pocet);

				$seznam = Seznam::findOne($seznam_id);
				$seznam->rezerva = $rezerva_new;
				$seznam->predpoklad_stav = $predpoklad_stav_new;
				$seznam->update();
			}
		}
		else if($nabidky['status_id'] == 2 && $nabidky['objednavka_vystavena'] == 1) // Objednávka + Objednavka vystavena
		{
			// seznam
			$nseznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();

			foreach($nseznam as $ns)
			{
				$seznam_id = $ns['seznam_id'];
				$pocet = $ns['pocet'];	

				$sz = Seznam::find()->where(['id' => $seznam_id])->one();
				$rezerva_old = $sz['rezerva']; 
				$objednano_old = $sz['objednano'];

				$rezerva_new = intval($rezerva_old - $pocet);
				$objednano_new = intval($objednano_old - $pocet);

				$seznam = Seznam::findOne($seznam_id);
				$seznam->rezerva = $rezerva_new;
				$seznam->objednano = $objednano_new;
				$seznam->update();
			}
		}
		
		// Delete
		$nb = Nabidky::findOne($id);
		$nb->smazat = 1;
		$nb->update();
		
		// Log
		$addLog = Log::addLog("Smazal nabídku", $id);
		Yii::$app->session->setFlash('success', "Nabidka smazaná úspěšně");
		
		//$this->findModel($id)->delete();
		
        return $this->redirect(['index']);
    }

    /**
     * Finds the Nabidky model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nabidky the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nabidky::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionChange($id) // Stav
    {
		$nabidka = Nabidky::findOne($id);

		$status_id_old = $nabidka['status_id']; // old status id
		$status_id_new = Yii::$app->request->get('newstatus_id'); // new status id
		
		if ($status_id_old == 1 && $status_id_new == 2) // nabidka -> objednavka
		{
			$nbd = Nabidky::findOne($id);
			$nbd->objednavka_vystavena = 0;
			$nbd->faktura_vydana = 0;
			$nbd->dlist_vydany = 0;
			$nbd->update();
			
			$nseznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();
			
			foreach($nseznam as $ns)
			{
				$seznam_id = $ns['seznam_id'];
				$pocet = $ns['pocet'];
				
				$sz = Seznam::findOne($seznam_id);
				$rezerva_old = $sz['rezerva']; 
				$predpoklad_stav_old = $sz['predpoklad_stav'];
				
				$rezerva_new = intval($rezerva_old + $pocet);
				$predpoklad_stav_new = intval($predpoklad_stav_old - $pocet);
				
				$sz->rezerva = $rezerva_new;
				$sz->predpoklad_stav = $predpoklad_stav_new;
				$sz->update();
			}
			
			// Log
			$addLog = Log::addLog("Změnil stáv (Nabídka -> Objednávka)", $id);
			Yii::$app->session->setFlash('success', "Stáv změněn úspěšně");
		}
		else if ($status_id_old == 1 && $status_id_new == 3) // nabidka -> nerealizováno 
		{
			// Log
			$addLog = Log::addLog("Změnil stáv (Nabídka -> Nerealizováno)", $id);	
			Yii::$app->session->setFlash('success', "Stáv změněn úspěšně");
		}
		else if ($status_id_old == 2 && $status_id_new == 3) // objednavka -> nerealizováno 
		{
			if($nabidka['objednavka_vystavena'] == 0)
			{
				$nseznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();
			
				foreach($nseznam as $ns)
				{
					$seznam_id = $ns['seznam_id'];
					$pocet = $ns['pocet'];
					
					$sz = Seznam::findOne($seznam_id);
					$rezerva_old = $sz['rezerva']; 
					$predpoklad_stav_old = $sz['predpoklad_stav'];

					$rezerva_new = intval($rezerva_old - $pocet);
					$predpoklad_stav_new = intval($predpoklad_stav_old + $pocet);

					$sz->rezerva = $rezerva_new;
					$sz->predpoklad_stav = $predpoklad_stav_new;
					$sz->update();
				}
			}
			// Log
			$addLog = Log::addLog("Změnil stáv (Objednavka -> Nerealizováno)", $id);
			Yii::$app->session->setFlash('success', "Stáv změněn úspěšně");
		}
		else if ($status_id_old == 3 && $status_id_new == 2) // nerealizovano -> objednavka
		{
			$nbd = Nabidky::findOne($id);
			$nbd->objednavka_vystavena = 0;
			$nbd->faktura_vydana = 0;
			$nbd->dlist_vydany = 0;
			$nbd->update();
			
			$nseznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();
			
			foreach($nseznam as $ns)
			{
				$seznam_id = $ns['seznam_id'];
				$pocet = $ns['pocet'];
				
				$sz = Seznam::find()->where(['id' => $seznam_id])->one();
				$rezerva_old = $sz['rezerva']; 
				$predpoklad_stav_old = $sz['predpoklad_stav'];
				
				$rezerva_new = intval($rezerva_old + $pocet);
				$predpoklad_stav_new = intval($predpoklad_stav_old - $pocet);
				
				$seznam = Seznam::findOne($seznam_id);
				$seznam->rezerva = $rezerva_new;
				$seznam->predpoklad_stav = $predpoklad_stav_new;
				$seznam->update();
			}
			
			// Log
			$addLog = Log::addLog("Změnil stáv (Nabídka -> Objednávka)", $id);
			Yii::$app->session->setFlash('success', "Stáv změněn úspěšně");
		}
		else if ($status_id_old == 4 && $status_id_new == 2) // dokonceno -> objednavka
		{
			$nbd = Nabidky::findOne($id);
			$nbd->objednavka_vystavena = 0;
			$nbd->faktura_vydana = 0;
			$nbd->dlist_vydany = 0;
			$nbd->update();
			
			$nseznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();
			
			foreach($nseznam as $ns)
			{
				$seznam_id = $ns['seznam_id'];
				$pocet = $ns['pocet'];
				
				$sz = Seznam::find()->where(['id' => $seznam_id])->one();
				$rezerva_old = $sz['rezerva']; 
				$predpoklad_stav_old = $sz['predpoklad_stav'];
				
				$rezerva_new = intval($rezerva_old + $pocet);
				$predpoklad_stav_new = intval($predpoklad_stav_old - $pocet);
				
				$seznam = Seznam::findOne($seznam_id);
				$seznam->rezerva = $rezerva_new;
				$seznam->predpoklad_stav = $predpoklad_stav_new;
				$seznam->update();
			}
			
			// Log
			$addLog = Log::addLog("Změnil stáv (Nabídka -> Objednávka)", $id);
			Yii::$app->session->setFlash('success', "Stáv změněn úspěšně");
		}
			
		$nabidky = Nabidky::findOne($id);
		$nabidky->status_id = $status_id_new;
		$nabidky->update();
		
        return $this->redirect(['../nabidky']);
    }
	/*
	public function actionPrevzit($id) // Prevzit
    {
		//$nabidka = Nabidky::find()->where(['id' => $id])->one();
		$prevzit_id = Yii::$app->request->get('prevzit_id');
		/*
		if ($prevzit_id == 1) // Objednavka vystavena
		{
			return $this->redirect(['../nabidky/update/' . $id .'?objednavka_vystavena=1']);

			// Log
			$addLog = Log::addLog("Převzál (Objednávka -> Objednávka vystavená)", $id);
			Yii::$app->session->setFlash('success', "Objednávka vystavená přidána úspěšně");
			
			return $this->redirect(['../nabidky']);
		}
		 * 
		 */
		/*
		if($prevzit_id == 2) // Faktura vydana
		{
			return $this->redirect(['../nabidky/update/' . $id .'?faktura_vydana=1']);
		}
		 * 
		 */
		/*
		if($prevzit_id == 3) // Dodací list vzdaný
		{
			return $this->redirect(['../nabidky/update/' . $id .'?dlist_vydany=1']);
		}
		 * 
		 */
		/*
		if($prevzit_id == 4) // Zálohová faktura
		{
			return $this->redirect(['../nabidky/update/' . $id .'?faktura_zalohova=1']);
		}
		*/
		/*
		return $this->redirect(['../nabidky']);
    }	
	*/
	
	public function actionShowView()
	{
		$nid = (int) Yii::$app->request->get('nid');
		$data['table'] = '';
		
		$nabidky = Nabidky::findOne($nid);
		
		$data['cislo'] = 'Nabidka č.' . $nabidky->cislo;
		
		$data['table'] = ''
			. '<div style="float: left; width: 50%;">Odběratel: <b>' . Zakazniky::getName($nabidky->zakazniky_id) . '</b></div>'
			. '<div style="float: left; width: 50%; text-align: right;">Vystavil: ' . UserIdentity::findIdentity($nabidky->user_id)->name. ' &nbsp;&nbsp;&nbsp;&nbsp; Dat.vystavení: ' . date("d.m.Y", strtotime($nabidky->vystaveno)) . '</div>';
		
		$nabidky_seznam = NabidkySeznam::find()->where(['nabidky_id' => $nid])->all();
		$i = 1;
		
		$data['table'] = $data['table'] . '<div style="float: left; width: 100%; margin-top: 20px;">Položky vystavené nabidky:</div>'
			. '<table class="table table-striped table-bordered">'
			. '<thead>'
			. '<tr>'
			. '<th>ID</th>'
			. '<th>Název</th>'
			. '<th>Kód</th>'
			. '<th>Počet</th>'
			. '<th>Sleva</th>'
			. '<th>Cena</th>'
			. '<th>Typ ceny</th>'
			. '<th>Sazba DPH</th>'
			. '<th>Celkem</th>'
			. '<th>DPH</th>'
			. '<th>Včetně DPH</th>'
			. '</tr>'
			. '</thead>'
			. '<tbody>';

		foreach ($nabidky_seznam as $ns)
		{
			$data['table'] = $data['table']  . '<tr>';
			$data['table'] = $data['table']  . '<td>' . $i . '</td>';
			$data['table'] = $data['table']  . '<td>' . Seznam::seznamName($ns->seznam_id) . '</td>';
			$data['table'] = $data['table']  . '<td>' . Seznam::getPlu($ns->seznam_id) . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->pocet . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->sleva . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->cena . '</td>';
			$data['table'] = $data['table']  . '<td>' . NabidkySeznam::getTypCeny($ns->id) . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->sazba_dph . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->celkem . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->celkem_dph . '</td>';
			$data['table'] = $data['table']  . '<td>' . $ns->vcetne_dph . '</td>';
			$data['table'] = $data['table']  . '</tr>';
			$i++;
			
			$celkem[] = $ns->celkem;
			$celkem_dph[] = $ns->celkem_dph;
			$vcetne_dph[] = $ns->vcetne_dph;
		}
		
		$data['table'] = $data['table'] . '<tr style="font-weight: bold;"><td colspan="7"></td><td>Celkem:</td><td>'. number_format(array_sum($celkem), 2, '.', '') .'</td><td>'. number_format(array_sum($celkem_dph), 2, '.', '') .'</td><td>'. number_format(array_sum($vcetne_dph), 2, '.', '') .'</td></tr>';
		$data['table'] = $data['table'] . '</tbody></table>';


		return json_encode($data);
	}
	
	public function actionPrint($id)
	{
		$nabidky = Nabidky::findOne($id);
		$zakazniky = Zakazniky::findOne($nabidky->zakazniky_id);
		$countries_f = Countries::findOne($zakazniky->f_countries_id);
		$countries_d = Countries::findOne($zakazniky->p_countries_id);
		$nabidky_seznam = NabidkySeznam::find()->where(['nabidky_id' => $id])->all();
		
		$content = $this->renderPartial('template-pdf', [
												'id' => $nabidky->id, 
												'cislo' => $nabidky->cislo,
												'vystaveno' => date('d.m.Y', strtotime($nabidky->vystaveno)),
												'platnost' => date('d.m.Y', strtotime($nabidky->platnost)),
												'zname' => $zakazniky->o_name,
												'zico' => $zakazniky->ico,
												'zdic' => $zakazniky->dic,
												'zfulice' => $zakazniky->f_ulice,
												'zfpsc' => $zakazniky->f_psc,
												'zfmesto' => $zakazniky->f_mesto,
												'zfzeme' => $countries_f->name,
												'zdulice' => $zakazniky->p_ulice,
												'zdpsc' => $zakazniky->p_psc,
												'zdmesto' => $zakazniky->p_mesto,
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
			'filename' => "Nabidka-{$id}.pdf",
			'content' => $content,  	
		]);

		return $pdf->render();
	}
	
}
