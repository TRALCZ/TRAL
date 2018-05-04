<?php

namespace app\controllers;

use Yii;
use app\models\Moneys;
use app\models\Zakazniky;
use app\models\ZakaznikySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use bupy7\xml\constructor\XmlConstructor;
use DOMDocument;
use app\models\Countries;
use app\models\ZakaznikySkupina;
use app\models\ZakaznikyKlice;
use app\models\Klice;
use app\models\ZakaznikyCenovaHladina;
use app\models\ZakaznikyCeniky;
use app\models\CenovaHladina;
use app\models\Ceniky;
use app\models\Log;

/**
 * ZakaznikyController implements the CRUD actions for Zakazniky model.
 */
class ZakaznikyController extends Controller
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
     * Lists all Zakazniky models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZakaznikySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Zakazniky model.
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
     * Creates a new Zakazniky model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Zakazniky();

        if ($model->load(Yii::$app->request->post())) {
			
			$model->uuid = Moneys::createID();
			$model->uuid_kontaktni_osoba = Moneys::createID();
			$model->uuid_email = Moneys::createID();
			$model->uuid_web = Moneys::createID();
			$model->uuid_phone = Moneys::createID();
			$model->uuid_mobil = Moneys::createID();
			$model->klice = json_encode(Yii::$app->request->post('a-klice'));
			$model->c_hladina = json_encode(Yii::$app->request->post('c-hladina'));
			$model->ceniky = json_encode(Yii::$app->request->post('ceniky'));
			
			// ceniky
			/*
			$count_polozka = Yii::$app->request->post('count_polozka');	
			
			$massiv = array();
			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);
				$cena = Yii::$app->request->post('cena' . $i); 
				
				if ($seznam_id > 0)
				{
					$massiv[$seznam_id]=$cena;
				}
			}	
			if (count($massiv) > 0)
			{
				$model->ceniky = json_encode($massiv);
			}
			else
			{
				$model->ceniky = NULL;
			}
			
			 * 
			 */
			
			if($model->is_fa == '0')
			{
				$model->f_name = NULL;
				$model->f_ulice = NULL;
				$model->f_mesto = NULL;
				$model->f_psc = NULL;
				$model->f_countries_id = NULL;
			}
			
			if($model->is_pa == '0')
			{
				$model->p_name = NULL;
				$model->p_ulice = NULL;
				$model->p_mesto = NULL;
				$model->p_psc = NULL;
				$model->p_countries_id = NULL;
			}
			
			$model->save();
			
			$id = $model->id;
			
			if (count(Yii::$app->request->post('a-klice')) > 0)
			{
				foreach (Yii::$app->request->post('a-klice') as $mk)
				{
					$zakaznikyKlice = new ZakaznikyKlice;
					$zakaznikyKlice->klice_id = $mk;
					$zakaznikyKlice->klice_uuid = Moneys::createID();
					$zakaznikyKlice->zakazniky_id = $model->id;
					$zakaznikyKlice->insert();
				}
			}
			
			if(count(Yii::$app->request->post('c-hladina')) > 0)
			{
				foreach (Yii::$app->request->post('c-hladina') as $ch)
				{
					$zakaznikyCH = new ZakaznikyCenovaHladina;
					$zakaznikyCH->cenova_hladina_id = $ch;
					$zakaznikyCH->cenova_hladina_uuid = Moneys::createID();
					$zakaznikyCH->zakazniky_id = $model->id;
					$zakaznikyCH->insert();
				}
			}
			
			if(count(Yii::$app->request->post('ceniky')) > 0)
			{
				foreach (Yii::$app->request->post('ceniky') as $cn)
				{
					$zakaznikyCN = new ZakaznikyCeniky;
					$zakaznikyCN->ceniky_id = $cn;
					$zakaznikyCN->ceniky_uuid = Moneys::createID();
					$zakaznikyCN->zakazniky_id = $model->id;
					$zakaznikyCN->insert();
				}
			}
			
			
			$o_country = Countries::FindOne($model->o_countries_id);
			$o_cname = $o_country->name;
			
			$f_country = Countries::FindOne($model->f_countries_id);
			$f_cname = $f_country->name;
			
			$p_country = Countries::FindOne($model->p_countries_id);
			$p_cname = $p_country->name;
			
			$zskupina = ZakaznikySkupina::FindOne($model->zakazniky_skupina_id);
			$uuid_zs = $zskupina->uuid;
			
			
			// Log
			$log = Log::addLog("Přidal zákazníka", $model->id);
			
			// Create XML
			$xml = new DomDocument('1.0', 'utf-8');
			$s5Data = $xml->appendChild($xml->createElement('S5Data'));
				$firmaList = $s5Data->appendChild($xml->createElement('FirmaList'));
					$firma = $firmaList->appendChild($xml->createElement('Firma'));
						$firma->setAttribute('ID', $model->uuid);
						$group_id = $firma->appendChild($xml->createElement('Group'));  // Group
							$group_id->setAttribute('ID', $uuid_zs);
						
						/*
						$kod = $firma->appendChild($xml->createElement('Kod'));  // Kod (?)
							$kod->appendChild($xml->createTextNode(5));
						 */
						$ico = $firma->appendChild($xml->createElement('ICO'));    // ICO
							$ico->appendChild($xml->createTextNode($model->ico));
						$dic = $firma->appendChild($xml->createElement('DIC'));    // DIC
							$dic->appendChild($xml->createTextNode($model->dic));
							
						$nazev = $firma->appendChild($xml->createElement('Nazev'));    // DIC
							$nazev->appendChild($xml->createTextNode($model->o_name));
							
						$adresy = $firma->appendChild($xml->createElement('Adresy'));
							
							$obchodniAdresa = $adresy->appendChild($xml->createElement('ObchodniAdresa'));
								$onazev = $obchodniAdresa->appendChild($xml->createElement('Nazev'));
									$onazev->appendChild($xml->createTextNode($model->o_name));
								$oulice = $obchodniAdresa->appendChild($xml->createElement('Ulice'));
									$oulice->appendChild($xml->createTextNode($model->o_ulice));
								$omesto = $obchodniAdresa->appendChild($xml->createElement('Misto'));
									$omesto->appendChild($xml->createTextNode($model->o_mesto));	
								$ocountry = $obchodniAdresa->appendChild($xml->createElement('NazevStatu'));
									$ocountry->appendChild($xml->createTextNode($o_cname));	
								$opsc = $obchodniAdresa->appendChild($xml->createElement('KodPsc'));
									$opsc->appendChild($xml->createTextNode($model->o_psc));
									
							$odlisnaFA = $adresy->appendChild($xml->createElement('OdlisnaFakturacniAdresa'));
								if($model->is_fa == '1')
								{
									$isfa = "True";
								}
								else
								{
									$isfa = "False";
								}
								$odlisnaFA->appendChild($xml->createTextNode($isfa));
								
							if($model->is_fa == '1')
							{		
								$fakturacniAdresa = $adresy->appendChild($xml->createElement('FakturacniAdresa'));
									$fnazev = $fakturacniAdresa->appendChild($xml->createElement('Nazev'));
										$fnazev->appendChild($xml->createTextNode($model->f_name));
									$fulice = $fakturacniAdresa->appendChild($xml->createElement('Ulice'));
										$fulice->appendChild($xml->createTextNode($model->f_ulice));
									$fmesto = $fakturacniAdresa->appendChild($xml->createElement('Misto'));
										$fmesto->appendChild($xml->createTextNode($model->f_mesto));	
									$fcountry = $fakturacniAdresa->appendChild($xml->createElement('NazevStatu'));
										$fcountry->appendChild($xml->createTextNode($f_cname));	
									$fpsc = $fakturacniAdresa->appendChild($xml->createElement('KodPsc'));
										$fpsc->appendChild($xml->createTextNode($model->f_psc));
							}	
								
								
							$odlisnaPA = $adresy->appendChild($xml->createElement('OdlisnaAdresaProvozovny'));
								if($model->is_pa == '1')
								{
									$ispa = "True";
								}
								else
								{
									$ispa = "False";
								}
								$odlisnaPA->appendChild($xml->createTextNode($ispa));
								
							
							if($model->is_pa == '1')
							{		
								$provozovna = $adresy->appendChild($xml->createElement('Provozovna'));
									$pnazev = $provozovna->appendChild($xml->createElement('Nazev'));
										$pnazev->appendChild($xml->createTextNode($model->p_name));
									$pulice = $provozovna->appendChild($xml->createElement('Ulice'));
										$pulice->appendChild($xml->createTextNode($model->p_ulice));
									$pmesto = $provozovna->appendChild($xml->createElement('Misto'));
										$pmesto->appendChild($xml->createTextNode($model->p_mesto));	
									$pcountry = $provozovna->appendChild($xml->createElement('NazevStatu'));
										$pcountry->appendChild($xml->createTextNode($p_cname));	
									$ppsc = $provozovna->appendChild($xml->createElement('KodPsc'));
										$ppsc->appendChild($xml->createTextNode($model->p_psc));		
							}
							
							$kontakty = $firma->appendChild($xml->createElement('Kontakty'));
								$email = $kontakty->appendChild($xml->createElement('Email'));
									$email->appendChild($xml->createTextNode($model->email));
								$www = $kontakty->appendChild($xml->createElement('WWW'));
									$www->appendChild($xml->createTextNode($model->web));	
								$telefon1 = $kontakty->appendChild($xml->createElement('Telefon1'));
									$cislo1 = $telefon1->appendChild($xml->createElement('Cislo'));
										$cislo1->appendChild($xml->createTextNode($model->phone));
								$telefon2 = $kontakty->appendChild($xml->createElement('Telefon2'));
									$cislo2 = $telefon2->appendChild($xml->createElement('Cislo'));
										$cislo2->appendChild($xml->createTextNode($model->mobil));		
										
								$emailSpojeni = $kontakty->appendChild($xml->createElement('EmailSpojeni'));
									$emailSpojeni->setAttribute('ID', $model->uuid_email);
								$wwwSpojeni = $kontakty->appendChild($xml->createElement('WWWSpojeni'));
									$wwwSpojeni->setAttribute('ID', $model->uuid_web);	
								$telefonSpojeni1 = $kontakty->appendChild($xml->createElement('TelefonSpojeni1'));
									$telefonSpojeni1->setAttribute('ID', $model->uuid_phone);		
								$telefonSpojeni2 = $kontakty->appendChild($xml->createElement('TelefonSpojeni2'));
									$telefonSpojeni2->setAttribute('ID', $model->uuid_mobil);
									
						
						$osoby = $firma->appendChild($xml->createElement('Osoby'));
							$hlavniOsoba = $osoby->appendChild($xml->createElement('HlavniOsoba'));
								$hlavniOsoba->setAttribute('ID', $model->uuid_kontaktni_osoba);
							$seznamOsob = $osoby->appendChild($xml->createElement('SeznamOsob'));
								$osoba = $seznamOsob->appendChild($xml->createElement('Osoba'));
									$osoba->setAttribute('ID', $model->uuid_kontaktni_osoba);
										$osnazev = $osoba->appendChild($xml->createElement('Nazev'));
											$osnazev->appendChild($xml->createTextNode($model->kontaktni_osoba));
										$cislo_osoby = $osoba->appendChild($xml->createElement('CisloOsoby'));
											$cislo_osoby->appendChild($xml->createTextNode("1"));
								
								
								
						$poznamka = $firma->appendChild($xml->createElement('Poznamka'));
							$poznamka->appendChild($xml->createTextNode($model->poznamka));
						
						// Pohledavky
						if($model->splatnost > 0)
						{
							$spl = $model->splatnost;
							$vsp = "True";
						}
						else
						{
							$spl = 0;
							$vsp = "False";
						}
						$pohledavky = $firma->appendChild($xml->createElement('Pohledavky'));	
							$splatnostPohledavek = $pohledavky->appendChild($xml->createElement('SplatnostPohledavek'));
								$splatnostPohledavek->appendChild($xml->createTextNode($spl));
							$vlastniSplatnostPohledavek = $pohledavky->appendChild($xml->createElement('VlastniSplatnostPohledavek'));
								$vlastniSplatnostPohledavek->appendChild($xml->createTextNode($vsp));	
						
						// Adresni klice	
						$aklice = $firma->appendChild($xml->createElement('AdresniKlice'));
							
							$all_klice = array();
							
							//$all_klice = ZakaznikyKlice::find($id)->all();
							$all_klice = ZakaznikyKlice::find()->where('zakazniky_id = ' . $id)->all();
							foreach($all_klice as $ak)
							{
								$fak = $aklice->appendChild($xml->createElement('FirmaAdresniKlic'));
									$fak->setAttribute('ID', $ak->klice_uuid);
									
									$kuuid = Klice::findOne($ak->klice_id);
									
									$aklid = $fak->appendChild($xml->createElement('AdresniKlic_ID'));
										$aklid->appendChild($xml->createTextNode($kuuid->uuid));
							}
						
						
						// Cenova hladina
						$obchodni_podminky = $firma->appendChild($xml->createElement('ObchodniPodminky'));	
						
							$shladin = $obchodni_podminky->appendChild($xml->createElement('SeznamHladin'));

								$all_ch = array();
								//$all_ch = ZakaznikyCenovaHladina::find($id)->all();
								$all_ch = ZakaznikyCenovaHladina::find()->where('zakazniky_id = ' . $id)->all();
								$ii = 1;
								foreach($all_ch as $chld)
								{
									$fch = $shladin->appendChild($xml->createElement('FirmaCenovaHladina'));
										$fch->setAttribute('ID', $chld->cenova_hladina_uuid);

										$chuuid = CenovaHladina::findOne($chld->cenova_hladina_id);

										$chladina = $fch->appendChild($xml->createElement('CenovaHladina_ID'));
											$chladina->appendChild($xml->createTextNode($chuuid->uuid));
										
										$poradi = $fch->appendChild($xml->createElement('Poradi'));	
											$poradi->appendChild($xml->createTextNode($ii));
										$ii++;			
								}
								
							// Ceniky
							$sceniku = $obchodni_podminky->appendChild($xml->createElement('SeznamCeniku'));

								$all_cn = array();
								//$all_ch = ZakaznikyCenovaHladina::find($id)->all();
								$all_cn = ZakaznikyCeniky::find()->where('zakazniky_id = ' . $id)->all();
								$iii = 1;
								foreach($all_cn as $cnld)
								{
									$fcn = $sceniku->appendChild($xml->createElement('FirmaCenik'));
										$fcn->setAttribute('ID', $cnld->ceniky_uuid);

										$cnuuid = Ceniky::findOne($cnld->ceniky_id);

										$cenik = $fcn->appendChild($xml->createElement('Cenik_ID'));
											$cenik->appendChild($xml->createTextNode($cnuuid->uuid));
										
										$poradiS = $fcn->appendChild($xml->createElement('Poradi'));	
											$poradiS->appendChild($xml->createTextNode($iii));
										$iii++;			
								}	
							
							
			$xml_list = $xml->saveXML();
			//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS
			
			$xml->formatOutput = true;
			$xml->save('xml/Firma-' . $model->ico . '.xml');
			
			//echo $model->id;
			
			return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Zakazniky model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post())) {
			
			$model->klice = json_encode(Yii::$app->request->post('a-klice'));
			
			// Adresni klice
			$all_klice_old = ZakaznikyKlice::find()->where('zakazniky_id = ' . $id)->all();
			
			ZakaznikyKlice::deleteKlice($id);
			
			if(count(Yii::$app->request->post('a-klice')) > 0)
			{
				foreach (Yii::$app->request->post('a-klice') as $mk)
				{
					$zakaznikyKlice = new ZakaznikyKlice;
					$zakaznikyKlice->klice_id = $mk;
					$zakaznikyKlice->klice_uuid = Moneys::createID();
					$zakaznikyKlice->zakazniky_id = $id;
					$zakaznikyKlice->insert();
				}
			}
			
			$model->c_hladina = json_encode(Yii::$app->request->post('c-hladina'));
			
			
			$all_ch_old = ZakaznikyCenovaHladina::find()->where('zakazniky_id = ' . $id)->all(); // Cenova hladina
			$all_cn_old = ZakaznikyCeniky::find()->where('zakazniky_id = ' . $id)->all(); // Ceniky
			
			ZakaznikyCenovaHladina::deleteCH($id);
			
			if (count(Yii::$app->request->post('c-hladina')) > 0)
			{
				foreach (Yii::$app->request->post('c-hladina') as $ch)
				{
					$zakaznikyCH = new ZakaznikyCenovaHladina;
					$zakaznikyCH->cenova_hladina_id = $ch;
					$zakaznikyCH->cenova_hladina_uuid = Moneys::createID();
					$zakaznikyCH->zakazniky_id = $id;
					$zakaznikyCH->insert();
				}
			}
			
			$model->ceniky = json_encode(Yii::$app->request->post('ceniky'));
			// Ceniky
			$all_cn_old = ZakaznikyCeniky::find()->where('zakazniky_id = ' . $id)->all();
			
			ZakaznikyCeniky::deleteCN($id);
			
			if (count(Yii::$app->request->post('ceniky')) > 0)
			{
				foreach (Yii::$app->request->post('ceniky') as $cn)
				{
					$zakaznikyCN = new ZakaznikyCeniky;
					$zakaznikyCN->ceniky_id = $cn;
					$zakaznikyCN->ceniky_uuid = Moneys::createID();
					$zakaznikyCN->zakazniky_id = $id;
					$zakaznikyCN->insert();
				}
			}
			
			// ceniky
			/*
			$count_polozka = Yii::$app->request->post('count_polozka');	
			
			$massiv = array();
			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);
				$cena = Yii::$app->request->post('cena' . $i); 
				
				if ($seznam_id > 0)
				{
					$massiv[$seznam_id]=$cena;
				}
			}	
			if (count($massiv) > 0)
			{
				$model->ceniky = json_encode($massiv);
			}
			else
			{
				$model->ceniky = NULL;
			}
			*/
			
			$model->save();
			
			
			$o_country = Countries::FindOne($model->o_countries_id);
			$o_cname = $o_country->name;
			
			$f_country = Countries::FindOne($model->f_countries_id);
			$f_cname = $f_country->name;
			
			$p_country = Countries::FindOne($model->p_countries_id);
			$p_cname = $p_country->name;
			
			$zskupina = ZakaznikySkupina::FindOne($model->zakazniky_skupina_id);
			$uuid_zs = $zskupina->uuid;
			
			// Create XML
			$xml = new DomDocument('1.0', 'utf-8');
			$s5Data = $xml->appendChild($xml->createElement('S5Data'));
				$firmaList = $s5Data->appendChild($xml->createElement('FirmaList'));
					$firma = $firmaList->appendChild($xml->createElement('Firma'));
						$firma->setAttribute('ID', $model->uuid);
						
						$group_id = $firma->appendChild($xml->createElement('Group'));  // Group
							$group_id->setAttribute('ID', $uuid_zs);
							
						$ico = $firma->appendChild($xml->createElement('ICO'));    // ICO
							$ico->appendChild($xml->createTextNode($model->ico));
						$dic = $firma->appendChild($xml->createElement('DIC'));    // DIC
							$dic->appendChild($xml->createTextNode($model->dic));
							
						$nazev = $firma->appendChild($xml->createElement('Nazev'));    // DIC
							$nazev->appendChild($xml->createTextNode($model->o_name));
							
						$adresy = $firma->appendChild($xml->createElement('Adresy'));
							
							$obchodniAdresa = $adresy->appendChild($xml->createElement('ObchodniAdresa'));
								$onazev = $obchodniAdresa->appendChild($xml->createElement('Nazev'));
									$onazev->appendChild($xml->createTextNode($model->o_name));
								$oulice = $obchodniAdresa->appendChild($xml->createElement('Ulice'));
									$oulice->appendChild($xml->createTextNode($model->o_ulice));
								$omesto = $obchodniAdresa->appendChild($xml->createElement('Misto'));
									$omesto->appendChild($xml->createTextNode($model->o_mesto));	
								$ocountry = $obchodniAdresa->appendChild($xml->createElement('NazevStatu'));
									$ocountry->appendChild($xml->createTextNode($o_cname));	
								$opsc = $obchodniAdresa->appendChild($xml->createElement('KodPsc'));
									$opsc->appendChild($xml->createTextNode($model->o_psc));
						
							$odlisnaFA = $adresy->appendChild($xml->createElement('OdlisnaFakturacniAdresa'));
								if($model->is_fa == '1')
								{
									$isfa = "True";
								}
								else
								{
									$isfa = "False";
								}
								$odlisnaFA->appendChild($xml->createTextNode($isfa));
								
							if($model->is_fa == '1')
							{		
								$fakturacniAdresa = $adresy->appendChild($xml->createElement('FakturacniAdresa'));
									$fnazev = $fakturacniAdresa->appendChild($xml->createElement('Nazev'));
										$fnazev->appendChild($xml->createTextNode($model->f_name));
									$fulice = $fakturacniAdresa->appendChild($xml->createElement('Ulice'));
										$fulice->appendChild($xml->createTextNode($model->f_ulice));
									$fmesto = $fakturacniAdresa->appendChild($xml->createElement('Misto'));
										$fmesto->appendChild($xml->createTextNode($model->f_mesto));	
									$fcountry = $fakturacniAdresa->appendChild($xml->createElement('NazevStatu'));
										$fcountry->appendChild($xml->createTextNode($f_cname));	
									$fpsc = $fakturacniAdresa->appendChild($xml->createElement('KodPsc'));
										$fpsc->appendChild($xml->createTextNode($model->f_psc));
							}
								
							$odlisnaPA = $adresy->appendChild($xml->createElement('OdlisnaAdresaProvozovny'));
								if($model->is_pa == '1')
								{
									$ispa = "True";
								}
								else
								{
									$ispa = "False";
								}
								$odlisnaPA->appendChild($xml->createTextNode($ispa));
								
							if($model->is_pa == '1')
							{		
								$provozovna = $adresy->appendChild($xml->createElement('Provozovna'));
									$pnazev = $provozovna->appendChild($xml->createElement('Nazev'));
										$pnazev->appendChild($xml->createTextNode($model->p_name));
									$pulice = $provozovna->appendChild($xml->createElement('Ulice'));
										$pulice->appendChild($xml->createTextNode($model->p_ulice));
									$pmesto = $provozovna->appendChild($xml->createElement('Misto'));
										$pmesto->appendChild($xml->createTextNode($model->p_mesto));	
									$pcountry = $provozovna->appendChild($xml->createElement('NazevStatu'));
										$pcountry->appendChild($xml->createTextNode($p_cname));	
									$ppsc = $provozovna->appendChild($xml->createElement('KodPsc'));
										$ppsc->appendChild($xml->createTextNode($model->p_psc));		
							}
							
							$kontakty = $firma->appendChild($xml->createElement('Kontakty'));
								$email = $kontakty->appendChild($xml->createElement('Email'));
									$email->appendChild($xml->createTextNode($model->email));
								$www = $kontakty->appendChild($xml->createElement('WWW'));
									$www->appendChild($xml->createTextNode($model->web));	
								$telefon1 = $kontakty->appendChild($xml->createElement('Telefon1'));
									$cislo1 = $telefon1->appendChild($xml->createElement('Cislo'));
										$cislo1->appendChild($xml->createTextNode($model->phone));
								$telefon2 = $kontakty->appendChild($xml->createElement('Telefon2'));
									$cislo2 = $telefon2->appendChild($xml->createElement('Cislo'));
										$cislo2->appendChild($xml->createTextNode($model->mobil));		

								$emailSpojeni = $kontakty->appendChild($xml->createElement('EmailSpojeni'));
									$emailSpojeni->setAttribute('ID', $model->uuid_email);
								$wwwSpojeni = $kontakty->appendChild($xml->createElement('WWWSpojeni'));
									$wwwSpojeni->setAttribute('ID', $model->uuid_web);	
								$telefonSpojeni1 = $kontakty->appendChild($xml->createElement('TelefonSpojeni1'));
									$telefonSpojeni1->setAttribute('ID', $model->uuid_phone);		
								$telefonSpojeni2 = $kontakty->appendChild($xml->createElement('TelefonSpojeni2'));
									$telefonSpojeni2->setAttribute('ID', $model->uuid_mobil);

									
						$osoby = $firma->appendChild($xml->createElement('Osoby'));
							$hlavniOsoba = $osoby->appendChild($xml->createElement('HlavniOsoba'));
								$hlavniOsoba->setAttribute('ID', $model->uuid_kontaktni_osoba);
							$seznamOsob = $osoby->appendChild($xml->createElement('SeznamOsob'));
								$osoba = $seznamOsob->appendChild($xml->createElement('Osoba'));
									$osoba->setAttribute('ID', $model->uuid_kontaktni_osoba);
										$osnazev = $osoba->appendChild($xml->createElement('Nazev'));
											$osnazev->appendChild($xml->createTextNode($model->kontaktni_osoba));
										$cislo_osoby = $osoba->appendChild($xml->createElement('CisloOsoby'));
											$cislo_osoby->appendChild($xml->createTextNode("1"));	
							
						// Poznamka
						$poznamka = $firma->appendChild($xml->createElement('Poznamka'));
							$poznamka->appendChild($xml->createTextNode($model->poznamka));
						
						// Pohledavky
						if($model->splatnost > 0)
						{
							$spl = $model->splatnost;
							$vsp = "True";
						}
						else
						{
							$spl = 0;
							$vsp = "False";
						}
						$pohledavky = $firma->appendChild($xml->createElement('Pohledavky'));	
							$splatnostPohledavek = $pohledavky->appendChild($xml->createElement('SplatnostPohledavek'));
								$splatnostPohledavek->appendChild($xml->createTextNode($spl));
							$vlastniSplatnostPohledavek = $pohledavky->appendChild($xml->createElement('VlastniSplatnostPohledavek'));
								$vlastniSplatnostPohledavek->appendChild($xml->createTextNode($vsp));
								
						// Adresni klice	
						$aklice = $firma->appendChild($xml->createElement('AdresniKlice'));
							
							if(count($all_klice_old) > 0)
							{
								foreach($all_klice_old as $akl)
								{
									$fak = $aklice->appendChild($xml->createElement('FirmaAdresniKlic'));
										$fak->setAttribute('ID', $akl->klice_uuid);
										$fak->setAttribute('Delete', '1');
								}
							}
							
							//$all_klice = ZakaznikyKlice::find($id)->all();
							$all_klice = ZakaznikyKlice::find()->where('zakazniky_id = ' . $id)->all();
							
							if(count($all_klice) > 0)
							{
								foreach($all_klice as $ak)
								{
									$fak = $aklice->appendChild($xml->createElement('FirmaAdresniKlic'));
										$fak->setAttribute('ID', $ak->klice_uuid);

										$kuuid = Klice::findOne($ak->klice_id);

										$aklid = $fak->appendChild($xml->createElement('AdresniKlic_ID'));
											$aklid->appendChild($xml->createTextNode($kuuid->uuid));
								}
							}
						
						
						// Cenova hladina
						$obchodni_podminky = $firma->appendChild($xml->createElement('ObchodniPodminky'));
						
							$shladin = $obchodni_podminky->appendChild($xml->createElement('SeznamHladin'));

								foreach($all_ch_old as $chl)
								{
									$fch = $shladin->appendChild($xml->createElement('FirmaCenovaHladina'));
										$fch->setAttribute('ID', $chl->cenova_hladina_uuid);
										$fch->setAttribute('Delete', '1');
								}

								//$all_ch = ZakaznikyCenovaHladina::find($id)->all();
								$all_ch = ZakaznikyCenovaHladina::find()->where('zakazniky_id = ' . $id)->all();
								$ii = 1;
								foreach($all_ch as $chld)
								{
									$fch = $shladin->appendChild($xml->createElement('FirmaCenovaHladina'));
										$fch->setAttribute('ID', $chld->cenova_hladina_uuid);

										$chuuid = CenovaHladina::findOne($chld->cenova_hladina_id);

										$chladina = $fch->appendChild($xml->createElement('CenovaHladina_ID'));
											$chladina->appendChild($xml->createTextNode($chuuid->uuid));
										
										$poradi = $fch->appendChild($xml->createElement('Poradi'));	
											$poradi->appendChild($xml->createTextNode($ii));
										$ii++;			
								}
							
							// Ceniky
							$sceniky = $obchodni_podminky->appendChild($xml->createElement('SeznamCeniku'));

								foreach($all_cn_old as $chl)
								{
									$fcn = $sceniky->appendChild($xml->createElement('FirmaCenik'));
										$fcn->setAttribute('ID', $chl->ceniky_uuid);
										$fcn->setAttribute('Delete', '1');
								}

								//$all_ch = ZakaznikyCenovaHladina::find($id)->all();
								$all_cn = ZakaznikyCeniky::find()->where('zakazniky_id = ' . $id)->all();
								$iii = 1;
								foreach($all_cn as $cnld)
								{
									$fcn = $sceniky->appendChild($xml->createElement('FirmaCenik'));
										$fcn->setAttribute('ID', $cnld->ceniky_uuid);

										$cnuuid = Ceniky::findOne($cnld->ceniky_id);

										$scenik = $fcn->appendChild($xml->createElement('Cenik_ID'));
											$scenik->appendChild($xml->createTextNode($cnuuid->uuid));
										
										$poradiS = $fcn->appendChild($xml->createElement('Poradi'));	
											$poradiS->appendChild($xml->createTextNode($iii));
										$iii++;			
								}	
					
			$xml_list = $xml->saveXML();
			//$insert = Moneys::insertXML($xml_list);
			
			$xml->formatOutput = true;
			$xml->save('xml/Firma-' . $model->ico . '.xml');
		
			//return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Zakazniky model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Zakazniky model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zakazniky the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zakazniky::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
