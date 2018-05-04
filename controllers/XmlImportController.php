<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use DiDom\Document;
use DiDom\Element;
use DiDom\Query;

use app\models\XmlImport;
use app\models\XmlImportSearch;
use app\models\TitleArrayTyp;
use app\models\TitleArrayTypOptions;
use app\models\MergeArrayTyp;
use app\models\MergeArrayTypOptions;
use app\models\MergeArrayZarubneTyp;
use app\models\MergeArrayZarubneTypOptions;
/**
 * XmlImportController implements the CRUD actions for XmlImport model.
 */
class XmlImportController extends Controller
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
     * Lists all XmlImport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new XmlImportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single XmlImport model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new XmlImport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new XmlImport();

        if ($model->load(Yii::$app->request->post()))
		{
			$model->datetime = date('Y-m-d H:i:s');
			$model->user_id = Yii::$app->user->getID();
			//$model->kosik = $model->kosik * 1;
			
			$file = UploadedFile::getInstance($model, 'file');
			if ($file && $file->tempName)
			{
				$model->file = $file;
				if ($model->validate(['file']))
				{
					$dir = Yii::getAlias('xml-import/');
					$fileName = $model->file->baseName . '.' . $model->file->extension;
					$model->file->saveAs($dir . $fileName);
					$model->file = '/' . $dir . $fileName;
					$fileputh = $dir . $fileName;
				}
			}
			
			if ($model->save()) // add to xml_import table
			{
				$url = 'http://erkadob2b.pl/';
				$login = 'submited=logowanie&log_login=rostra&log_pass=ERKado9421787111dvere';
				$loginUrl = 'http://erkadob2b.pl/?page=nowe_zamowienie';
				
				$dvereUrl = 'http://erkadob2b.pl/?subpage=skrzydlo_drzwiowe';
				$ramaUrl  = 'http://erkadob2b.pl/?subpage=oscieznica';
				$garnyzUrl = 'http://erkadob2b.pl/?subpage=szyna_z_maskownica';
				$nadpraziUrl = 'http://erkadob2b.pl/?subpage=belka';
				$stojinyUrl = 'http://erkadob2b.pl/?subpage=baza';

				$cislo_kosiku = $model->kosik;
				$sendDvere = '&submited=t1&basket=' . $cislo_kosiku;
				$sendRama  = '&submited=t2&basket=' . $cislo_kosiku;
				$sendGarnyz = '&submited=t12&basket=' . $cislo_kosiku;
				$sendNadprazi = '&submited=t5&basket=' . $cislo_kosiku;
				$sendStojiny = '&submited=t6&basket=' . $cislo_kosiku;
				$check = '&ajax=1';
				
				$orders_array = array();
				
				$xml = simplexml_load_file($fileputh);
				foreach ($xml->Detail1->Detail1->children() as $key => $value) 
				{
					if ($value->Detail1)
					{
						$num = (string) $value->Detail1->{'_18'};
						$orders_array[$num]['tite'] = (string) $value->Detail1->{'_0'};
						$orders_array[$num]['count'] = (string) $value->Detail1->{'_4'};
						$orders_array[$num]['note'] = (string) $value->Detail1->{'_52'};
					}
				}
				
				///////////////////////////////////////////     $title_array     /////////////////////////////////////////////////////////
				
				$title_array = array();
				$tat = TitleArrayTyp::find()->all();
				
				foreach($tat as $ta)
				{
					$tato = TitleArrayTypOptions::find()->where(['title_array_typ_id' => $ta->id])->all();

					$tato_array = array();
					foreach($tato as $tao)
					{
						$tato_array[$tao->name] = $tao->znac;
					}
					$title_array[$ta->name] = $tato_array;
				}
				
				///////////////////////////////////////////     $merge_array     /////////////////////////////////////////////////////////

				$merge_array = array();
				$mat = MergeArrayTyp::find()->all();

				foreach($mat as $ma)
				{
					$mato = MergeArrayTypOptions::find()->where(['merge_array_typ_id' => $ma->id])->all();

					$mato_array = array();
					foreach($mato as $mao)
					{
						$mato_array[$mao->name] = $mao->znac;
					}
					$merge_array[$ma->name] = $mato_array;
				}
				
				///////////////////////////////////////////     $merge_array_zarubne     ////////////////////////////////////////////////////

				$merge_array_zarubne = array();
				$matz = MergeArrayZarubneTyp::find()->all();

				foreach($matz as $maz)
				{
					$matoz = MergeArrayZarubneTypOptions::find()->where(['merge_array_zarubne_typ_id' => $maz->id])->all();

					$matoz_array = array();
					foreach($matoz as $maoz)
					{
						$matoz_array[$maoz->name] = $maoz->znac;
					}
					$merge_array_zarubne[$maz->name] = $matoz_array;
				}
				
				$merge_array_zarubne['widePlusDirection'] = array( // f3s
									'60L' => array('wide' => '60', 'direction' => 'L'),
									'70L' => array('wide' => '70', 'direction' => 'L'),
									'80L' => array('wide' => '80', 'direction' => 'L'),
									'90L' => array('wide' => '90', 'direction' => 'L'),
									'100L' => array('wide' => '100', 'direction' => 'L'),
									'110L' => array('wide' => '110', 'direction' => 'L'),
									'120L' => array('wide' => '120', 'direction' => 'L'),
									'130L' => array('wide' => '130', 'direction' => 'L'),
									'140L' => array('wide' => '140', 'direction' => 'L'),
									'150L' => array('wide' => '150', 'direction' => 'L'),
									'160L' => array('wide' => '160', 'direction' => 'L'),
									'170L' => array('wide' => '170', 'direction' => 'L'),
									'180L' => array('wide' => '180', 'direction' => 'L'),
									'190L' => array('wide' => '190', 'direction' => 'L'),
									'200L' => array('wide' => '200', 'direction' => 'L'),
									'60P' => array('wide' => '60', 'direction' => 'P'),
									'70P' => array('wide' => '70', 'direction' => 'P'),
									'80P' => array('wide' => '80', 'direction' => 'P'),
									'90P' => array('wide' => '90', 'direction' => 'P'),
									'100P' => array('wide' => '100', 'direction' => 'P'),
									'110P' => array('wide' => '110', 'direction' => 'P'),
									'120P' => array('wide' => '120', 'direction' => 'P'),
									'130P' => array('wide' => '130', 'direction' => 'P'),
									'140P' => array('wide' => '140', 'direction' => 'P'),
									'150P' => array('wide' => '150', 'direction' => 'P'),
									'160P' => array('wide' => '160', 'direction' => 'P'),
									'170P' => array('wide' => '170', 'direction' => 'P'),
									'180P' => array('wide' => '180', 'direction' => 'P'),
									'190P' => array('wide' => '190', 'direction' => 'P'),
									'200P' => array('wide' => '200', 'direction' => 'P'),
					);
				
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				$query_array = array(
					// "ch_norm" => '2',	// ??? NORMA polska=1 czeska=2
					"norma_ss" => '',	//  NORMA polska=1 czeska=2
					"f1s" => '',		// TECHNOLOGIA soft=2 stile=3 cpl=4 lak=5 twin=6 szklane=7
					"f2s" => '',		// MODEL aleja=230 azalia=67 berberys=204 ...
					"f3s" => '',		// SZEROKOŚĆ 60=60 70=70 80=80 90=90 100=100
					"f4s" => '',		// KOLOR akacja=26 orzech=27 szary dąb=28 
					"f5s" => '',		// KIERUNEK lewe=1 prawe=2
					"f6s" => '',		// TYP pokojowe=1 łazienkowe=2 pełne=3
					"f7s" => '',		// ZAMEK na klucz wc=2 na wkładkę patentową=3 bez otworu na klucz=4
					"f8s" => '',		// WYPEŁNIENIE plaster miodu=1 płyta Homalight=3
					"f9s" => '',		// ZAWIASY 3 zawiasy=2
					"f10s" => '',	// SZKLENIE
					"f11s" => '',	// WENTYLACJA
					"f12s" => '',	// ILOŚĆ SZTUK
					"f13s" => '',	// RODZAJ
					"f14s" => '',	// ZAKRES
					"f15s" => '',	// OPCJA SZKLENIA
					"f16s" => '',	// 
					"f17s" => '',	// 
					"f18s" => '',	// 
					"f19s" => '',	// 
					"f20s" => '',	// 
					"f21s" => '',	// KIERUNEK SZKLENIA
					"f22s" => '',	// 
					"f23s" => '',	// 
					"f24s" => '',	// ELEKTROZACZEP
					"f25s" => '',	// 
					"f26s" => '',	// 
					"f27s" => '',	// OPASKA-KATOWNIKA
					"f28s" => '',	// 
					"dwzs" => '',	// WZMOCNIENIE POD SAMOZAMYKACZ
					"drds" => '',	// 
					"jms" => '',	// 
					"doms" => '',	// 
					"dos" => '',	// OŚCIEŻNICA
					"dkas" => '',	// 
					"syns" => '',	// 
					"rodzs" => '',	// 
					"bls" => '',	// 
					"f40s" => '',	// 
					"bier_s" => '',	// 
					"f4s_os" => '',	// 
					"dbs" => '',	// 
					"fpzs" => '',	// 
					"dws" => '',	// 
					"does" => '',	// 
				);

				
					$merge_array_garnyz = array(
						'KOLOR' => array( // f4s
							'OŘECH GREKO/BÍLÝ GREKO' => 'orzech greko/bialy greko',
							'OŘECH GR/BÍLÝ GR' => 'orzech greko/bialy greko',
							'OŘECH/BÍLÝ GREKO' => 'orzech greko/bialy greko',
							'OŘECH/BÍLÝ GR' => 'orzech greko/bialy greko',
							'BÍLÝ GREKO' => 'biały greko',
							'BÍLÝ GR' => 'biały greko',
							'DUB GREKO' => 'dąb greko',
							'DUB GR' => 'dąb greko',
							'DUB STŘEDNÍ GREKO' => 'dąb średni greko',
							'DUB STŘEDNÍ GR' => 'dąb średni greko',
							'OŘECH GREKO' => 'orzech greko',
							'OŘECH GR' => 'orzech greko',
							'SANREMO GREKO' => 'sanremo greko',
							'SANREMO GR' => 'sanremo greko',
							'SONOMA GREKO' => 'sonoma greko',
							'SONOMA GR' => 'sonoma greko',
							'BOROVICE BÍLÁ GREKO' => 'sosna biała greko',
							'BOROVICE BÍLÁ GR' => 'sosna biała greko',
							'WENGE GREKO' => 'wenge greko',
							'WENGE GR' => 'wenge greko',
							'JILM GREKO' => 'wiąz greko',
							'JILM GR' => 'wiąz greko',
							'ZLATÝ DUB GREKO' => 'złoty dąb greko',
							'ZLATÝ DUB GR' => 'złoty dąb greko',
							'ZL.DUB GREKO' => 'złoty dąb greko',
							'ZL DUB GREKO' => 'złoty dąb greko',
							'AKÁCIE CPL' => 'akacja cpl',
							'AKACIE CPL' => 'akacja cpl',
							'OŘECH CPL' => 'orzech cpl',
							'ŠEDÝ DUB CPL' => 'szary dąb cpl',
							'DUB ŠEDÝ CPL' => 'szary dąb cpl',

							'AKÁCIE' => 'akacja',
							'AKACIE' => 'akacja',
							'AKÁCIE SOFT' => 'akacja',
							'AKÁCIE FINISH' => 'akacja',
							'AKÁCIE FIN' => 'akacja',
							'AKÁCIE FIN.' => 'akacja',

							'SVĚTLÁ AKÁCIE' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE SOFT' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FINISH' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FIN' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FIN.' => 'jasna akacja',
							'SVĚT AKÁCIE' => 'jasna akacja',
							'SVĚT AKÁCIE SOFT' => 'jasna akacja',
							'SVĚT AKÁCIE FINISH' => 'jasna akacja',
							'SVĚT AKÁCIE FIN' => 'jasna akacja',
							'SVĚT AKÁCIE FIN.' => 'jasna akacja',
							'SVĚ AKÁCIE' => 'jasna akacja',
							'SVĚ AKÁCIE SOFT' => 'jasna akacja',
							'SVĚ AKÁCIE FINISH' => 'jasna akacja',
							'SVĚ AKÁCIE FIN' => 'jasna akacja',
							'SVĚ AKÁCIE FIN.' => 'jasna akacja',
							'SV.AKÁCIE' => 'jasna akacja',
							'SV. AKÁCIE' => 'jasna akacja',
							'SV.AKÁCIE SOFT' => 'jasna akacja',
							'SV.AKÁCIE FINISH' => 'jasna akacja',
							'SV.AKÁCIE FIN' => 'jasna akacja',
							'SV.AKÁCIE FIN.' => 'jasna akacja',
							'SV AKÁCIE' => 'jasna akacja',
							'SV AKÁCIE SOFT' => 'jasna akacja',
							'SV AKÁCIE FINISH' => 'jasna akacja',
							'SV AKÁCIE FIN' => 'jasna akacja',
							'SV AKÁCIE FIN.' => 'jasna akacja',
							'SVĚT. AKÁCIE' => 'jasna akacja',
							'SVĚT. AKÁCIE SOFT' => 'jasna akacja',
							'SVĚT. AKÁCIE FINISH' => 'jasna akacja',
							'SVĚT. AKÁCIE FIN' => 'jasna akacja',
							'SVĚT. AKÁCIE FIN.' => 'jasna akacja',

							'OŘECH' => 'orzech',
							'OŘECH SOFT' => 'orzech',
							'OŘECH FINISH' => 'orzech',
							'OŘECH FIN' => 'orzech',
							'OŘECH FIN.' => 'orzech',

							'WENGE' => 'wenge',
							'WENGE SOFT' => 'wenge',
							'WENGE FINISH' => 'wenge',
							'WENGE FIN' => 'wenge',
							'WENGE FIN.' => 'wenge',

							'WENGE CPL' => 'wenge cpl',

							'BUK' => 'buk',
							'BUK SOFT' => 'buk',
							'BUK FINISH' => 'buk',
							'BUK FIN' => 'buk',
							'BUK FIN.' => 'buk',

							'BÍLÝ' => 'biały',
							'BÍLÝ SOFT' => 'biały',
							'BÍLÝ FINISH' => 'biały',
							'BÍLÝ FIN' => 'biały',
							'BÍLÝ FIN.' => 'biały',

							'BÍLÝ LAK' => 'biały lak',
							'BUK LAK' => 'buk lak',
							'CALVADOS LAK' => 'calvados lak',
							'DUB LAK' => 'dąb lak',
							'OLŠE LAK' => 'olcha lak',

							'ŠEDÝ DUB GREKO' => 'dąb szary greko',
							'DUB ŠEDÝ GREKO' => 'dąb szary greko',
							'DUB ŠEDÝ GR' => 'dąb szary greko',
							'DUB ŠEDÝ GR.' => 'dąb szary greko',

							// premium
							'DUB PREMIUM' => 'dąb premium',
							'JAVOR ŠEDÝ PREMIUM' => 'klon szary premium',
							'KŮRA BÍLÁ PREMIUM' => 'kora biała premium',
							'OŘECH PREMIUM' => 'orzech premium',

						),
						'SZEROKOŚĆ GARNÝŽ' => array( // f3s
							'60-70' => '70 - szyna wraz z maskownicą 150 cm',
							'80' => '80 - szyna wraz z maskownicą 180 cm',
							'90' => '90 - szyna wraz z maskownicą 200 cm',
							'100' => '100 - szyna wraz z maskownicą 210 cm',
							'60-70x2' => '2x70 - szyna wraz z maskownicą 2x150 cm',
							'80x2' => '2x80 - szyna wraz z maskownicą 2x180 cm',
							'90x2' => '2x90 - szyna wraz z maskownicą 2x200 cm',
							'100x2' => '2x100 - szyna wraz z maskownicą 2x210 cm',
						),	
						'RODZAJ SKRZYDŁA' => array( // f7s
							'DORAZ.' => 'bez zamka hakowego',
							'DORAZ. ZAM' => 'z zamkiem hakowym',
						),	
						'NORMA' => array( // norma_ss
							'PL' => 'polska',
							'CZ' => 'czeska',
						),
						'ILOŚĆ SZTUK' => array( // f12s количество - штук 1- 100
						),


					);
				
					
					$merge_array_nadprazi = array(
						'NORMA' => array( // norma_ss
							'PL' => 'polska',
							'CZ' => 'czeska',
						),
						'RODZAJ / TYP' => array( // f13s
							'STALEJ' => 'do ościeżnicy stałej',
							'REGULOVANEJ' => 'do ościeżnicy regulowanej',
							'SP1N' => 'do SP1N / tunel',
							'SP2N' => 'do SP2N / tunel',
							'SP1C-125' => 'do SP1C.125',
							'SP1C-100' => 'do SP1C.100',
							'NAKLAD' => 'do ościeżnicy reg. nakładkowej',
							'DRAZKOVANEj' => 'do ościeżnicy reg. bezprzylgowej',
						),
						'SZEROKOŚĆ' => array( // f3s
							'60' => '60',
							'70' => '70',
							'80' => '80',
							'90' => '90',
							'100' => '100',
						),
						'ZAKRES' => array( // f14s
							'80-100' => '80-100',
							'100-120' => '100-120',
							'120-140' => '120-140',
							'140-160' => '140-160',
							'160-180' => '160-180',
							'180-200' => '180-200',
							'200-220' => '200-220',
							'220-240' => '220-240',
							'240-260' => '240-260',
							'260-280' => '260-280',
							'280-300' => '280-300',
							'300-320' => '300-320',
							'320-340' => '320-340',
							'340-360' => '340-360',
							'360-380' => '360-380',
							'380-400' => '380-400',
							'400-420' => '400-420',
							'420-440' => '420-440',
							'440-460' => '440-460',
							'460-480' => '460-480',
							'480-500' => '480-500',
							'500-520' => '500-520',

						),
						'KOLOR' => array( // f4s
							'OŘECH GREKO' => 'orzech greko',
							'BÍLÝ GREKO' => 'biały greko',
							'OŘECH GR' => 'orzech greko',
							'BÍLÝ GR' => 'biały greko',
							'OŘECH' => 'orzech',
							'BÍLÝ GREKO' => 'biały greko',
							'OŘECH' => 'orzech',
							'BÍLÝ GR' => 'biały greko',
							'BÍLÝ GREKO' => 'biały greko',
							'BÍLÝ GR' => 'biały greko',
							'DUB GREKO' => 'dąb greko',
							'DUB GR' => 'dąb greko',
							'DUB STŘEDNÍ GREKO' => 'dąb średni greko',
							'DUB STŘEDNÍ GR' => 'dąb średni greko',
							'OŘECH GREKO' => 'orzech greko',
							'OŘECH GR' => 'orzech greko',
							'SANREMO GREKO' => 'sanremo greko',
							'SANREMO GR' => 'sanremo greko',
							'SONOMA GREKO' => 'sonoma greko',
							'SONOMA GR' => 'sonoma greko',
							'BOROVICE BÍLÁ GREKO' => 'sosna biała greko',
							'BOROVICE BÍLÁ GR' => 'sosna biała greko',
							'WENGE GREKO' => 'wenge greko',
							'WENGE GR' => 'wenge greko',
							'JILM GREKO' => 'wiąz greko',
							'JILM GR' => 'wiąz greko',
							'ZLATÝ DUB GREKO' => 'złoty dąb greko',
							'ZLATÝ DUB GR' => 'złoty dąb greko',
							'ZL.DUB GREKO' => 'złoty dąb greko',
							'ZL DUB GREKO' => 'złoty dąb greko',
							'AKÁCIE CPL' => 'akacja cpl',
							'AKACIE CPL' => 'akacja cpl',
							'OŘECH CPL' => 'orzech cpl',
							'ŠEDÝ DUB CPL' => 'szary dąb cpl',
							'DUB ŠEDÝ CPL' => 'szary dąb cpl',

							'AKÁCIE' => 'akacja',
							'AKÁCIE SOFT' => 'akacja',
							'AKÁCIE FINISH' => 'akacja',
							'AKÁCIE FIN' => 'akacja',
							'AKÁCIE FIN.' => 'akacja',

							'SVĚTLÁ AKÁCIE' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE SOFT' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FINISH' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FIN' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FIN.' => 'jasna akacja',
							'SVĚT AKÁCIE' => 'jasna akacja',
							'SVĚT AKÁCIE SOFT' => 'jasna akacja',
							'SVĚT AKÁCIE FINISH' => 'jasna akacja',
							'SVĚT AKÁCIE FIN' => 'jasna akacja',
							'SVĚT AKÁCIE FIN.' => 'jasna akacja',
							'SVĚ AKÁCIE' => 'jasna akacja',
							'SVĚ AKÁCIE SOFT' => 'jasna akacja',
							'SVĚ AKÁCIE FINISH' => 'jasna akacja',
							'SVĚ AKÁCIE FIN' => 'jasna akacja',
							'SVĚ AKÁCIE FIN.' => 'jasna akacja',
							'SV.AKÁCIE' => 'jasna akacja',
							'SV. AKÁCIE' => 'jasna akacja',
							'SV.AKÁCIE SOFT' => 'jasna akacja',
							'SV.AKÁCIE FINISH' => 'jasna akacja',
							'SV.AKÁCIE FIN' => 'jasna akacja',
							'SV.AKÁCIE FIN.' => 'jasna akacja',
							'SV AKÁCIE' => 'jasna akacja',
							'SV AKÁCIE SOFT' => 'jasna akacja',
							'SV AKÁCIE FINISH' => 'jasna akacja',
							'SV AKÁCIE FIN' => 'jasna akacja',
							'SV AKÁCIE FIN.' => 'jasna akacja',
							'SVĚT. AKÁCIE' => 'jasna akacja',
							'SVĚT. AKÁCIE SOFT' => 'jasna akacja',
							'SVĚT. AKÁCIE FINISH' => 'jasna akacja',
							'SVĚT. AKÁCIE FIN' => 'jasna akacja',
							'SVĚT. AKÁCIE FIN.' => 'jasna akacja',

							'OŘECH' => 'orzech',
							'OŘECH SOFT' => 'orzech',
							'OŘECH FINISH' => 'orzech',
							'OŘECH FIN' => 'orzech',
							'OŘECH FIN.' => 'orzech',

							'WENGE' => 'wenge',
							'WENGE SOFT' => 'wenge',
							'WENGE FINISH' => 'wenge',
							'WENGE FIN' => 'wenge',
							'WENGE FIN.' => 'wenge',

							'BUK' => 'buk',
							'BUK SOFT' => 'buk',
							'BUK FINISH' => 'buk',
							'BUK FIN' => 'buk',
							'BUK FIN.' => 'buk',

							'BÍLÝ' => 'biały',
							'BÍLÝ SOFT' => 'biały',
							'BÍLÝ FINISH' => 'biały',
							'BÍLÝ FIN' => 'biały',
							'BÍLÝ FIN.' => 'biały',

							'BÍLÝ LAK' => 'biały lak',
							'BUK LAK' => 'buk lak',
							'CALVADOS LAK' => 'calvados lak',
							'DUB LAK' => 'dąb lak',
							'OLŠE LAK' => 'olcha lak',
							'WENGE CPL' => 'wenge cpl',

							'ŠEDÝ DUB GREKO' => 'dąb szary greko',
							'DUB ŠEDÝ GREKO' => 'dąb szary greko',
							'DUB ŠEDÝ GR' => 'dąb szary greko',
							'DUB ŠEDÝ GR.' => 'dąb szary greko',

							// premium
							'DUB PREMIUM' => 'dąb premium',
							'JAVOR ŠEDÝ PREMIUM' => 'klon szary premium',
							'KŮRA BÍLÁ PREMIUM' => 'kora biała premium',
							'OŘECH PREMIUM' => 'orzech premium',

						),
						'ILOŚĆ SZTUK' => array( // f12s количество - штук 1- 100
						),


					);		
				
				
					$merge_array_stojiny = array(
						'NORMA' => array( // norma_ss
							'PL' => 'polska',
							'CZ' => 'czeska',
						),
						'RODZAJ / TYP' => array( // f13s
							'STALEJ' => 'do ościeżnicy stałej',
							'REGULOVANEJ' => 'do ościeżnicy regulowanej',
							'SP1N' => 'do SP1N',
							'SP1C-125' => 'do SP1C.125',
							'SP1C-100' => 'do SP1C.100',
							'NAKLAD' => 'do ościeżnicy reg. nakładkowej',
							'DRAZKOVANEj' => 'do ościeżnicy reg. bezprzylgowej',
						),
						'KIERUNEK' => array( // f5s
							'L' => 'lewe',
							'P' => 'prawe',
						),
						'ZAKRES' => array( // f14s
							'80-100' => '80-100',
							'100-120' => '100-120',
							'120-140' => '120-140',
							'140-160' => '140-160',
							'160-180' => '160-180',
							'180-200' => '180-200',
							'200-220' => '200-220',
							'220-240' => '220-240',
							'240-260' => '240-260',
							'260-280' => '260-280',
							'280-300' => '280-300',
							'300-320' => '300-320',
							'320-340' => '320-340',
							'340-360' => '340-360',
							'360-380' => '360-380',
							'380-400' => '380-400',
							'400-420' => '400-420',
							'420-440' => '420-440',
							'440-460' => '440-460',
							'460-480' => '460-480',
							'480-500' => '480-500',
							'500-520' => '500-520',
						),
						'KOLOR' => array( // f4s
							'OŘECH GREKO' => 'orzech greko',
							'BÍLÝ GREKO' => 'biały greko',
							'OŘECH GR' => 'orzech greko',
							'BÍLÝ GR' => 'biały greko',
							'OŘECH' => 'orzech',
							'BÍLÝ GREKO' => 'biały greko',
							'OŘECH' => 'orzech',
							'BÍLÝ GR' => 'biały greko',
							'BÍLÝ GREKO' => 'biały greko',
							'BÍLÝ GR' => 'biały greko',
							'DUB GREKO' => 'dąb greko',
							'DUB GR' => 'dąb greko',
							'DUB STŘEDNÍ GREKO' => 'dąb średni greko',
							'DUB STŘEDNÍ GR' => 'dąb średni greko',
							'OŘECH GREKO' => 'orzech greko',
							'OŘECH GR' => 'orzech greko',
							'SANREMO GREKO' => 'sanremo greko',
							'SANREMO GR' => 'sanremo greko',
							'SONOMA GREKO' => 'sonoma greko',
							'SONOMA GR' => 'sonoma greko',
							'BOROVICE BÍLÁ GREKO' => 'sosna biała greko',
							'BOROVICE BÍLÁ GR' => 'sosna biała greko',
							'WENGE GREKO' => 'wenge greko',
							'WENGE GR' => 'wenge greko',
							'JILM GREKO' => 'wiąz greko',
							'JILM GR' => 'wiąz greko',
							'ZLATÝ DUB GREKO' => 'złoty dąb greko',
							'ZLATÝ DUB GR' => 'złoty dąb greko',
							'ZL.DUB GREKO' => 'złoty dąb greko',
							'ZL DUB GREKO' => 'złoty dąb greko',
							'AKÁCIE CPL' => 'akacja cpl',
							'AKACIE CPL' => 'akacja cpl',
							'OŘECH CPL' => 'orzech cpl',
							'ŠEDÝ DUB CPL' => 'szary dąb cpl',
							'DUB ŠEDÝ CPL' => 'szary dąb cpl',

							'AKÁCIE' => 'akacja',
							'AKÁCIE SOFT' => 'akacja',
							'AKÁCIE FINISH' => 'akacja',
							'AKÁCIE FIN' => 'akacja',
							'AKÁCIE FIN.' => 'akacja',

							'SVĚTLÁ AKÁCIE' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE SOFT' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FINISH' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FIN' => 'jasna akacja',
							'SVĚTLÁ AKÁCIE FIN.' => 'jasna akacja',
							'SVĚT AKÁCIE' => 'jasna akacja',
							'SVĚT AKÁCIE SOFT' => 'jasna akacja',
							'SVĚT AKÁCIE FINISH' => 'jasna akacja',
							'SVĚT AKÁCIE FIN' => 'jasna akacja',
							'SVĚT AKÁCIE FIN.' => 'jasna akacja',
							'SVĚ AKÁCIE' => 'jasna akacja',
							'SVĚ AKÁCIE SOFT' => 'jasna akacja',
							'SVĚ AKÁCIE FINISH' => 'jasna akacja',
							'SVĚ AKÁCIE FIN' => 'jasna akacja',
							'SVĚ AKÁCIE FIN.' => 'jasna akacja',
							'SV.AKÁCIE' => 'jasna akacja',
							'SV. AKÁCIE' => 'jasna akacja',
							'SV.AKÁCIE SOFT' => 'jasna akacja',
							'SV.AKÁCIE FINISH' => 'jasna akacja',
							'SV.AKÁCIE FIN' => 'jasna akacja',
							'SV.AKÁCIE FIN.' => 'jasna akacja',
							'SV AKÁCIE' => 'jasna akacja',
							'SV AKÁCIE SOFT' => 'jasna akacja',
							'SV AKÁCIE FINISH' => 'jasna akacja',
							'SV AKÁCIE FIN' => 'jasna akacja',
							'SV AKÁCIE FIN.' => 'jasna akacja',
							'SVĚT. AKÁCIE' => 'jasna akacja',
							'SVĚT. AKÁCIE SOFT' => 'jasna akacja',
							'SVĚT. AKÁCIE FINISH' => 'jasna akacja',
							'SVĚT. AKÁCIE FIN' => 'jasna akacja',
							'SVĚT. AKÁCIE FIN.' => 'jasna akacja',

							'OŘECH' => 'orzech',
							'OŘECH SOFT' => 'orzech',
							'OŘECH FINISH' => 'orzech',
							'OŘECH FIN' => 'orzech',
							'OŘECH FIN.' => 'orzech',

							'WENGE' => 'wenge',
							'WENGE SOFT' => 'wenge',
							'WENGE FINISH' => 'wenge',
							'WENGE FIN' => 'wenge',
							'WENGE FIN.' => 'wenge',

							'BUK' => 'buk',
							'BUK SOFT' => 'buk',
							'BUK FINISH' => 'buk',
							'BUK FIN' => 'buk',
							'BUK FIN.' => 'buk',

							'BÍLÝ' => 'biały',
							'BÍLÝ SOFT' => 'biały',
							'BÍLÝ FINISH' => 'biały',
							'BÍLÝ FIN' => 'biały',
							'BÍLÝ FIN.' => 'biały',

							'BÍLÝ LAK' => 'biały lak',
							'BUK LAK' => 'buk lak',
							'CALVADOS LAK' => 'calvados lak',
							'DUB LAK' => 'dąb lak',
							'OLŠE LAK' => 'olcha lak',
							'WENGE CPL' => 'wenge cpl',

							'ŠEDÝ DUB GREKO' => 'dąb szary greko',
							'DUB ŠEDÝ GREKO' => 'dąb szary greko',
							'DUB ŠEDÝ GR' => 'dąb szary greko',
							'DUB ŠEDÝ GR.' => 'dąb szary greko',

							// premium
							'DUB PREMIUM' => 'dąb premium',
							'JAVOR ŠEDÝ PREMIUM' => 'klon szary premium',
							'KŮRA BÍLÁ PREMIUM' => 'kora biała premium',
							'OŘECH PREMIUM' => 'orzech premium',

						),
						'ILOŚĆ SZTUK' => array( // f12s количество - штук 1- 100
						),


					);
				
				
				
				
					
					
					
					
					
					
					$orders_for_check = array();
					$ch = curl_init(); //init curl
					$html = $this->loginCurl($login, $loginUrl, $ch);  //Login to Site
					
					///echo "<table>";
					$array_errors = array();
					foreach ($orders_array as $key => $order)
					{
						///echo "<tr><td><b>ORDER $key : </b></td><td>" . $order['tite'] . '  ' . $order['count'] . "<br><small>" . $order['note'] . "</td>";
						$order_arr = $this->verify_order($order['tite'], $merge_array);

						// echo "order $key : <pre>" . print_r($order_arr, true) . "</pre>";
						// exit();

						$zakazUrl = $dvereUrl;
						$send = $sendDvere;
						if ($order_arr['error'] == 1)
						{
							if ($order_arr['dvere'] == 1) // Check if this is ZÁRUBEŇ
							{ 
								$order_arr = $this->verify_order_zarubne($order['tite'], $merge_array_zarubne);
								//echo "order $key : <pre>" . print_r($order_arr, true) . "</pre>";
								//exit();
								if ($order_arr['error'] == 1)
								{
									$array_errors[] = $order_arr['message'];
									///echo '<span style="color:red">' . $order_arr['message'] . '</span></td></tr>';
									///continue;
								}
								$zakazUrl = $ramaUrl;
								$send = $sendRama;
							} 
							elseif ($order_arr['dvere'] == 2) // Check if this is GARNYZ
							{
								$order_arr = $this->verify_order_garnyz($order['tite'], $merge_array_garnyz);
								if ($order_arr['error'] == 1)
								{
									$array_errors[] = $order_arr['message'];
									///echo '<td><span style="color:red">' . $order_arr['message'] . '</span></td></tr>';
									///continue;
								}
								$zakazUrl = $garnyzUrl;
								$send = $sendGarnyz;
							}
							elseif ($order_arr['dvere'] == 3) // Check if this is NADPRAŽÍ
							{
								$order_arr = $this->verify_order_nadprazi($order['tite'], $merge_array_nadprazi);
								if ($order_arr['error'] == 1)
								{
									$array_errors[] = $order_arr['message'];
									///echo '<td><span style="color:red">' . $order_arr['message'] . '</span></td></tr>';
									///continue;
								}
								$zakazUrl = $nadpraziUrl;
								$send = $sendNadprazi;
							}
							elseif ($order_arr['dvere'] == 4) // Check if this is STOJINY
							{
								$order_arr = $this->verify_order_stojiny($order['tite'], $merge_array_stojiny);
								if ($order_arr['error'] == 1)
								{
									$array_errors[] = $order_arr['message'];
									///echo '<td><span style="color:red">' . $order_arr['message'] . '</span></td></tr>';
									///continue;
								}
								$zakazUrl = $stojinyUrl;
								$send = $sendStojiny;
							}
							else
							{
								$array_errors[] = $order_arr['message'];
								///echo '<td><span style="color:red">' . $order_arr['message'] . '</span></td></tr>';
								///continue;
							}
						}
						unset($order_arr['error']);
						unset($order_arr['dvere']);

						// Fill Query string
						$f1s = (!empty($order_arr['TECHNOLOGIA'])) ? $title_array['TECHNOLOGIA'][$merge_array['TECHNOLOGIA'][$order_arr['TECHNOLOGIA']]] : '';
						$f2s = (!empty($order_arr['MODEL'])) ? $title_array['MODEL'][$merge_array['MODEL'][$order_arr['MODEL']]] : '';
						$f6s = (!empty($order_arr['TYP'])) ? $title_array['TYP'][$merge_array['TYP'][$order_arr['TYP']]] : '';

						// Kolour
						if ($zakazUrl == $dvereUrl)
						{
							$f4s = (!empty($order_arr['KOLOR'])) ? $title_array['KOLOR'][$merge_array['KOLOR'][$order_arr['KOLOR']]] : '';
						} 
						elseif ($zakazUrl == $garnyzUrl) 
						{
							$f4s = (!empty($order_arr['KOLOR'])) ? $title_array['KOLOR'][$merge_array_garnyz['KOLOR'][$order_arr['KOLOR']]] : '';
						}
						elseif ($zakazUrl == $nadpraziUrl) 
						{
							$f4s = (!empty($order_arr['KOLOR'])) ? $title_array['KOLOR'][$merge_array_nadprazi['KOLOR'][$order_arr['KOLOR']]] : '';
						}
						elseif ($zakazUrl == $stojinyUrl) 
						{
							$f4s = (!empty($order_arr['KOLOR'])) ? $title_array['KOLOR'][$merge_array_stojiny['KOLOR'][$order_arr['KOLOR']]] : '';
						}
						else 
						{
							$f4s = (!empty($order_arr['KOLOR'])) ? $title_array['KOLOR'][$merge_array_zarubne['KOLOR'][$order_arr['KOLOR']]] : '';
						}

						//$f3s = (!empty($order_arr['SZEROKOŚĆ'])) ? $title_array['SZEROKOŚĆ'][$merge_array['SZEROKOŚĆ'][$order_arr['SZEROKOŚĆ']]] : '';
						if ($zakazUrl == $dvereUrl)
						{
							$f3s = (!empty($order_arr['SZEROKOŚĆ'])) ? $title_array['SZEROKOŚĆ'][$merge_array['SZEROKOŚĆ'][$order_arr['SZEROKOŚĆ']]] : '';
						} 
						elseif ($zakazUrl == $garnyzUrl) 
						{
							$f3s = (!empty($order_arr['SZEROKOŚĆ GARNÝŽ'])) ? $title_array['SZEROKOŚĆ GARNÝŽ'][$merge_array_garnyz['SZEROKOŚĆ GARNÝŽ'][$order_arr['SZEROKOŚĆ GARNÝŽ']]] : '';
						}
						elseif ($zakazUrl == $nadpraziUrl) 
						{
							$f3s = (!empty($order_arr['SZEROKOŚĆ'])) ? $title_array['SZEROKOŚĆ'][$merge_array_nadprazi['SZEROKOŚĆ'][$order_arr['SZEROKOŚĆ']]] : '';
						}
						else 
						{
							$f3s = (!empty($order_arr['SZEROKOŚĆ'])) ? $title_array['SZEROKOŚĆ'][$merge_array['SZEROKOŚĆ'][$order_arr['SZEROKOŚĆ']]] : '';
						}

						$f5s = (!empty($order_arr['KIERUNEK'])) ? $title_array['KIERUNEK'][$merge_array['KIERUNEK'][$order_arr['KIERUNEK']]] : '';

						//$f7s = (!empty($order_arr['ZAMEK'])) ? $title_array['ZAMEK'][$merge_array['ZAMEK'][$order_arr['ZAMEK']]] : '';
						if ($zakazUrl == $dvereUrl)
						{
							$f7s = (!empty($order_arr['ZAMEK'])) ? $title_array['ZAMEK'][$merge_array['ZAMEK'][$order_arr['ZAMEK']]] : '';
						} 
						elseif ($zakazUrl == $garnyzUrl) 
						{
							$f7s = (!empty($order_arr['RODZAJ SKRZYDŁA'])) ? $title_array['RODZAJ SKRZYDŁA'][$merge_array_garnyz['RODZAJ SKRZYDŁA'][$order_arr['RODZAJ SKRZYDŁA']]] : '';
						}
						else 
						{
							$f7s = (!empty($order_arr['ZAMEK'])) ? $title_array['ZAMEK'][$merge_array['ZAMEK'][$order_arr['ZAMEK']]] : '';
						}

						$f8s = (!empty($order_arr['WYPEŁNIENIE'])) ? $title_array['WYPEŁNIENIE'][$merge_array['WYPEŁNIENIE'][$order_arr['WYPEŁNIENIE']]] : '';
						$f9s = (!empty($order_arr['ZAWIASY'])) ? $title_array['ZAWIASY'][$merge_array['ZAWIASY'][$order_arr['ZAWIASY']]] : '';
						$f10s = (!empty($order_arr['SZKLENIE'])) ? $title_array['SZKLENIE'][$merge_array['SZKLENIE'][$order_arr['SZKLENIE']]] : '5';
						$f11s = (!empty($order_arr['WENTYLACJA'])) ? $title_array['WENTYLACJA'][$merge_array['WENTYLACJA'][$order_arr['WENTYLACJA']]] : '';

						if ($zakazUrl == $nadpraziUrl)
						{
							//$f13s = (!empty($order_arr['RODZAJ / TYP'])) ? $title_array['RODZAJ / TYP'][$merge_array_nadprazi['RODZAJ / TYP'][$order_arr['RODZAJ / TYP']]] : '';
							$f13s = 2; // do ościeżnicy regulowanej
						}
						elseif ($zakazUrl == $stojinyUrl)
						{
							//$f13s = (!empty($order_arr['RODZAJ / TYP'])) ? $title_array['RODZAJ / TYP'][$merge_array_stojiny['RODZAJ / TYP'][$order_arr['RODZAJ / TYP']]] : '';
							$f13s = 2; // do ościeżnicy regulowanej
						}
						else
						{
							$f13s = (!empty($order_arr['RODZAJ'])) ? $title_array['RODZAJ'][$merge_array_zarubne['RODZAJ'][$order_arr['RODZAJ']]] : '';	
						}

						if ($zakazUrl == $nadpraziUrl)
						{
							$f14s = (!empty($order_arr['ZAKRES'])) ? $title_array['ZAKRES'][$merge_array_nadprazi['ZAKRES'][$order_arr['ZAKRES']]] : '';
						}
						elseif ($zakazUrl == $stojinyUrl)
						{
							$f14s = (!empty($order_arr['ZAKRES'])) ? $title_array['ZAKRES'][$merge_array_stojiny['ZAKRES'][$order_arr['ZAKRES']]] : '';
						}
						else
						{
							$f14s = (!empty($order_arr['ZAKRES'])) ? $title_array['ZAKRES'][$merge_array_zarubne['ZAKRES'][$order_arr['ZAKRES']]] : '';
						}


						if($f6s == 1)
						{
							$f15s = (!empty($order_arr['OPCJA SZKLENIA'])) ? $title_array['OPCJA SZKLENIA'][$merge_array['OPCJA SZKLENIA'][$order_arr['OPCJA SZKLENIA']]] : '';	
						}

						$f27s = (!empty($order_arr['OPASKA KĄTOWNIKA'])) ? $title_array['OPASKA KĄTOWNIKA'][$merge_array_zarubne['OPASKA KĄTOWNIKA'][$order_arr['OPASKA KĄTOWNIKA']]] : '';

						$norma_ss = (!empty($order_arr['NORMA'])) ? $title_array['NORMA'][$merge_array['NORMA'][$order_arr['NORMA']]] : '';

						$f12s = ($order['count'] > 0) ? $order['count'] : 1 ;
						$rwsk = 2; // 1 - standard, 2 - soft
				// $f7s = 0;
						$query_string = "&f1s=$f1s&f2s=$f2s&f6s=$f6s&f4s=$f4s&f3s=$f3s&f5s=$f5s&f7s=$f7s&f8s=$f8s&f9s=$f9s&f10s=$f10s&f11s=$f11s&f12s=$f12s&f13s=$f13s&f14s=$f14s&f15s=$f15s&f27s=$f27s&norma_ss=$norma_ss&rwks=$rwsk";
				//echo "order $key : $query_string" . $zakazUrl;
				//exit();

						$post = $query_string . $check;
						/* get page from site -> parse page*/
						$html = $this->loginCurl($post, $zakazUrl, $ch);

						//$document = new \DOMDocument($html);
						//$document = new \DOMDocument($html);
						$document = new Document($html);
						$parsed = $this->parse($document);
					//echo "<pre>".print_r($parsed, true)."</pre>";
					//exit();
						
						if ($parsed['ready'] == 1)
						{
							unset($parsed['ready']);
							$post = $send . $this->build_query_string($parsed);
				 //echo "query: " . $post . " " . $zakazUrl . " " . $ch;
				 //exit();
							//$ch = "Resource id #11";
							$html = $this->loginCurl($post, $zakazUrl, $ch); // Make Order on site
							
							///echo '<td><span style="color:green">OK! check KOSZYKI in <a href="http://erkadob2b.pl/">erkadob2b.pl</a> </span></td></tr>';
							
							Yii::$app->session->setFlash('success', "Položky přidané úspěšně");
						} 
						else
						{
							$array_errors[] = $parsed['message'];
							
							//echo '<td><span style="color:red">Error in query FORM: ';
							//echo $parsed['message'];
							//echo '</span></td></tr>';
							
							//exit();
						}
						$orders_for_check[] = $order_arr;
					}
					
					/*
					echo '</table><br><hr /><center><a href="" class="btn btn-primary" style="width: 150px;">Zpět</a></center><hr />';

					echo '<br><br><b>Please check Orders</b>';
					foreach ($orders_for_check as $key => $order)
					{
						echo "<br><b>Order $key: </b><table>";
						foreach ($order as $name => $val)
						{
							echo "<tr><td> $name </td><td> $val </td><td>".$merge_array[$name][$val]."</td></tr>";
						}
						echo '</table>';
					}
				
				
				
				
					exit();
					*/
					
					$xmlimport = XmlImport::findOne($model->id);
					$xmlimport->result = serialize($orders_for_check);
					$xmlimport->errors = serialize($array_errors);
					$xmlimport->update();
					
					if($xmlimport)
					{
						return $this->redirect(['view', 'id' => $model->id]);
					}
					
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing XmlImport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing XmlImport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the XmlImport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return XmlImport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = XmlImport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	public function loginCurl ($login, $loginUrl, $ch)
	{
		$cookie_file_path = 'cookie.txt';
		// $ch = curl_init(); //init curl
		curl_setopt($ch, CURLOPT_URL, $loginUrl); //Set the URL to work with
		curl_setopt($ch, CURLOPT_POST, 1); // ENABLE HTTP POST
		curl_setopt($ch, CURLOPT_POSTFIELDS, $login); //Set the post parameters
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path); //Handle cookies for the login

		//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
		//not to print out the results of its query.
		//Instead, it will return the results as a string return value
		//from curl_exec() instead of the usual true/false.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute the request
		$content = curl_exec($ch);

		return $content;
	}

	public function build_query_string($array)
	{
		$query_string = '';

		foreach ($array as $key => $value) {
			$query_string .= ($value !== NULL && $value !== FALSE && $value !== '') ? 
				'&'.$key.'='.$value : 
				'';
		}
		return $query_string;
	}

	/** parse array from HTML */
	public function parse($doc)
	{
		$array = array();
		$array['ready'] = 1;
	/* parse <select option=selected */
		foreach ($doc->find('select') as $element) {
			if (count($value = $element->find('option[selected]')) != 0) {
				$name = $element->attr('name');
				$value = $value[0]->attr('value');

				$array[$name] = $value;
			} else {
				$array['ready'] = 0;
				$array['message'] = $element->attr('title') . $element;
			}
		}
	/* parse <input type=hidden */
		foreach ($doc->find('input') as $element) {
			$name = $element->attr('name');
			$value = $element->attr('value');

			$array[$name] = $value;
		}

		return $array;
	}

	/** read string of order 
	* Orders:
	* DVEŘE BRAND 0/4 AKÁCIE SOFT 70 L BB CZ
	* DVEŘE BROADWAY 0/6 AKÁCIE CPL 100 L BB CZ
	* DVEŘE BERBERIS 1 BÍLÝ GREKO 60 L BB CZ
	* DVEŘE BRAND 0/4 AKÁCIE SOFT 70 L BB CZ
	* DVEŘE BRAND 0/4 SVÌTLÁ AKÁCIE SOFT 70 L BB PLT CZ
	* DVEŘE LEVANDULE 1 BÍLÝ GREKO 70 L BB CZ
	* DVEŘE LEVANDULE 1 BÍLÝ GREKO 70 L BB CZ VSG 221
	**/

	public function verify_order_garnyz($order, $merge_array)
	{
		// $array = explode(" ", $order); //В 1м заказе было 2 пробела
		$array = preg_split('/\s+/u', $order);
		// echo "array query : <pre>" . print_r($array, true) . "</pre>"; 

		$count = 0;
		$lenght = count($array) - 1;
	// Могут быть пустыми
		$order_arr['NORMA'] = '';
		$order_arr['SZEROKOŚĆ GARNÝŽ'] = '';
		$order_arr['KOLOR'] = '';
		$order_arr['RODZAJ SKRZYDŁA'] = '';
		$order_arr['ILOŚĆ SZTUK'] = '';
		$answer_array['error'] = 0;
		$answer_array['garnyz'] = 0;

	// 1е слово
		if ($array[$count] != 'GARNÝŽ') {
			$answer_array['message'] = 'Error! I dont know value: GARNÝŽ = ' . $array[$count];
			$answer_array['error'] = 1;
			$answer_array['garnyz'] = 1;

			return $answer_array;
		}
		$count++;	

		$count = $count+1;

		// 4,5,6е слова Цвет
		$colour1 = $array[$count]; // С 1го слова AKACIE
		$colour2 = $colour1 . " " . $array[$count+1]; // С 2х слов AKACIE FINISH
		$colour3 = $colour2 . " " . $array[$count+2]; // С 3х слов

		$shift = 3;
		$answer_array['KOLOR'] = $colour3;
		if (!array_key_exists($colour3, $merge_array['KOLOR'])) {
			if (!array_key_exists($colour2, $merge_array['KOLOR'])) {
				if (!array_key_exists($colour1, $merge_array['KOLOR'])) {
					$answer_array['message'] = 'Error! I dont know value: KOLOR = ' . $colour1;
					$answer_array['error'] = 1; 
					return $answer_array;
				}
				$answer_array['KOLOR'] = $colour1;
				$shift = 1;
			}
			if ($answer_array['KOLOR'] != $colour1) {
				$answer_array['KOLOR'] = $colour2;
				$shift = 2;
			}
		}
		$count += $shift;

		// SZEROKOŚĆ
		$array[$count]=str_replace('"','',$array[$count]);
		if (!array_key_exists($array[$count], $merge_array['SZEROKOŚĆ GARNÝŽ'])) {
			$answer_array['message'] = 'Error! I dont know value: SZEROKOŚĆ GARNÝŽ = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['SZEROKOŚĆ GARNÝŽ'] = $array[$count];
		$count++;


		// RODZAJ SKRZYDŁA может быть из 2х слов 'DORAZ. ZAM'
		$DORAZ1 = $array[$count]; // С 1го слова
		$DORAZ2 = $DORAZ1 . " " . $array[$count+1]; // С 2х слов
		$answer_array['RODZAJ SKRZYDŁA'] = $DORAZ2;
		$shift =2;
		$typ = false;
		if (!array_key_exists($DORAZ2, $merge_array['RODZAJ SKRZYDŁA'])) {
			if (!array_key_exists($DORAZ1, $merge_array['RODZAJ SKRZYDŁA'])) {
				$answer_array['message'] = 'Error! I dont know value: RODZAJ SKRZYDŁA = ' . $array[$count];
				$answer_array['error'] = 1; 
				return $answer_array;
			}
			$answer_array['RODZAJ SKRZYDŁA'] = $DORAZ1;
			$shift = 1;
			$typ = true;
		}
		$count += $shift;

		// Норма
		if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
			$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['NORMA'] = $array[$count];
		$count++;


		return $answer_array;
	}


	public function verify_order($order, $merge_array)
	{
		// $array = explode(" ", $order); //В 1м заказе было 2 пробела
		$array = preg_split('/\s+/u', $order);
		// echo "array query : <pre>" . print_r($array, true) . "</pre>"; 

		$count = 0;
		$lenght = count($array) - 1;
	// Могут быть пустыми
		$order_arr['TECHNOLOGIA'] = '';
		$order_arr['MODEL'] = '';
		$order_arr['TYP'] = '';
		$order_arr['KOLOR'] = '';
		$order_arr['SZEROKOŚĆ'] = '';
		$order_arr['KIERUNEK'] = '';
		$order_arr['ZAMEK'] = '';
		$order_arr['WYPEŁNIENIE'] = '';
		$order_arr['SZKLENIE'] = '';
		$order_arr['RODZAJ'] = '';
		$order_arr['ZAKRES'] = '';
		$order_arr['ZAWIASY'] = '';
		$order_arr['NORMA'] = '';
		$order_arr['WENTYLACJA'] = '';
		$order_arr['OPCJA SZKLENIA'] = '';
		$answer_array['error'] = 0;
		$answer_array['dvere'] = 0;

	// 1е слово
		if ($array[$count] != 'DVEŘE' AND $array[$count] != 'DVEØE') {
			$answer_array['message'] = 'Error! I dont know value: DVEŘE = ' . $array[$count];
			$answer_array['error'] = 1;
			$answer_array['dvere'] = 1;
			if ($array[$count] == 'GARNÝŽ')
			{
				$answer_array['dvere'] = 2;
			}
			if ($array[$count] == 'NADPRAŽÍ' || $array[$count] == 'NADPRAŽI')
			{
				$answer_array['dvere'] = 3;
			}
			if ($array[$count] == 'STOJINY')
			{
				$answer_array['dvere'] = 4;
			}

			return $answer_array;
		}
		$count++;

	// 2е слово: Модель И Технология (только 1 слово)
		if (!array_key_exists($array[$count], $merge_array['TECHNOLOGIA'])) {
			$answer_array['message'] = 'Error! I dont know value: TECHNOLOGIA = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['TECHNOLOGIA'] = $array[$count];
	// Модель может быть из 2х слов 'MAGNÓLIE 1'
		$MODEL1 = $array[$count]; // С 1го слова
		$MODEL2 = $MODEL1 . " " . $array[$count+1]; // С 2х слов
		$answer_array['MODEL'] = $MODEL2;

		$shift =2;
		$typ = false;
		if (!array_key_exists($MODEL2, $merge_array['MODEL'])) {
			if (!array_key_exists($MODEL1, $merge_array['MODEL'])) {
				$answer_array['message'] = 'Error! I dont know value: MODEL = ' . $array[$count];
				$answer_array['error'] = 1; 
				return $answer_array;
			}
			$answer_array['MODEL'] = $MODEL1;
			$shift = 1;
			$typ = true;
		}
		$count += $shift;

	// 3е слово Тип
		if ($typ) {

			// Защита от возможности задать несуществующие в Польше двери

			if($MODEL1 == 'BRAND' && $array[$count] == '2/4')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře BRAND 2/4 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'BRAND' && $array[$count] == '3/4')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře BRAND 3/4 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'SAMUN' && $array[$count] == '3/9')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře SAMUN 3/9 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'SAMUN' && $array[$count] == '4/9')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře SAMUN 4/9 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'SAMUN' && $array[$count] == '5/9')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře SAMUN 5/9 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'SAMUN' && $array[$count] == '6/9')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře SAMUN 6/9 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'SAMUN' && $array[$count] == '7/9')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře SAMUN 7/9 nemůžete zadat do systému.</strong></div>';
			}
			if($MODEL1 == 'SAMUN' && $array[$count] == '8/9')
			{
				$array[$count] = '<div style="color: red;"><strong>POZOR!!! Dveře SAMUN 8/9 nemůžete zadat do systému.</strong></div>';
			}
			/*
			echo $array[$count];
			echo $MODEL1;
			exit();
			*/



			if (!array_key_exists($array[$count], $merge_array['TYP'])) {
				$answer_array['message'] = 'Error! I dont know value: TYP = ' . $array[$count];
				$answer_array['error'] = 1; 


				return $answer_array;
			}


			$answer_array['TYP'] = $array[$count];

			if($answer_array['MODEL'] <> 'KLASIK')
			{
				$answer_array['OPCJA SZKLENIA'] = $array[$count];
			}

			//echo $answer_array['OPCJA SZKLENIA'] . ' -abc -';



	// Костыль для MODEL = HIELO
			if ($answer_array['MODEL'] == 'HIELO') {
				$answer_array['TYP'] = 'hielo ' . $answer_array['TYP'];
				if (!array_key_exists($answer_array['TYP'], $merge_array['TYP'])) {
					$answer_array['message'] = 'Error! I dont know value: TYP = ' . $answer_array['TYP'];
					$answer_array['error'] = 1; 
					return $answer_array;
				}
			}
			$count++;
		}

	// 4,5,6е слова Цвет
		$colour1 = $array[$count]; // С 1го слова
		$colour2 = $colour1 . " " . $array[$count+1]; // С 2х слов
		$colour3 = $colour2 . " " . $array[$count+2]; // С 3х слов
		$shift =3;
		$answer_array['KOLOR'] = $colour3;
		if (!array_key_exists($colour3, $merge_array['KOLOR'])) {
			if (!array_key_exists($colour2, $merge_array['KOLOR'])) {
				if (!array_key_exists($colour1, $merge_array['KOLOR'])) {
					$answer_array['message'] = 'Error! I dont know value: KOLOR = ' . $colour1;
					$answer_array['error'] = 1; 
					return $answer_array;
				}
				$answer_array['KOLOR'] = $colour1;
				$shift = 1;
			}
			if ($answer_array['KOLOR'] != $colour1) {
				$answer_array['KOLOR'] = $colour2;
				$shift = 2;
			}
		}
		$count += $shift;

	// Технология последнее слово в цвете
		$exploded = explode(" ", $answer_array['KOLOR']);
		$exploded = array_pop($exploded);
		$tehno_from_color = $answer_array['TECHNOLOGIA'] . ' ' . $exploded;
		$tehno_after_color = $answer_array['TECHNOLOGIA'] . ' ' . $array[$count];
		$tehno_single_from_color = $exploded;
		$tehno_single_after_color = $array[$count];
		if (array_key_exists($tehno_from_color, $merge_array['TECHNOLOGIA'])) {
			$answer_array['TECHNOLOGIA'] = $tehno_from_color;
		} elseif (array_key_exists($tehno_after_color, $merge_array['TECHNOLOGIA'])) {
			$answer_array['TECHNOLOGIA'] = $tehno_after_color;
			$count++;
		} elseif (array_key_exists($tehno_single_from_color, $merge_array['TECHNO_SINGLE_WORD'])) {
			$answer_array['TECHNOLOGIA'] = $tehno_single_from_color;
		} elseif (array_key_exists($tehno_single_after_color, $merge_array['TECHNO_SINGLE_WORD'])) {
			$answer_array['TECHNOLOGIA'] = $tehno_single_after_color;
			$count++;
		}

	// 5 или 6 или 7 слово Ширина
		if (!array_key_exists($array[$count], $merge_array['SZEROKOŚĆ'])) {
			$answer_array['message'] = 'Error! I dont know value: SZEROKOŚĆ = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['SZEROKOŚĆ'] = $array[$count];
		$count++;

	// Левый/Правый
		if (!array_key_exists($array[$count], $merge_array['KIERUNEK'])) {
			$answer_array['message'] = 'Error! I dont know value: KIERUNEK = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['KIERUNEK'] = $array[$count];
		$count++;

	// Замок
		if (!array_key_exists($array[$count], $merge_array['ZAMEK'])) {
			$answer_array['message'] = 'Error! I dont know value: ZAMEK = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['ZAMEK'] = $array[$count];
		$count++;
	// WYPEŁNIENIE или NORMA или SZKLENIE или WENTYLACJA (могут быть, а могут и не быть)
		for ($i=$count; $i <= $lenght; $i++) { 
			if (array_key_exists($array[$i], $merge_array['WYPEŁNIENIE'])) {
				$answer_array['WYPEŁNIENIE'] = $array[$i];
			}
			if (array_key_exists($array[$i], $merge_array['ZAWIASY'])) {
				$answer_array['ZAWIASY'] = $array[$i];
			}
			if (array_key_exists($array[$i], $merge_array['NORMA'])) {
				$answer_array['NORMA'] = $array[$i];
			}
			if (array_key_exists($array[$i], $merge_array['SZKLENIE'])) {
				$answer_array['SZKLENIE'] = $array[$i];
			}
			if (array_key_exists($array[$i], $merge_array['WENTYLACJA'])) {
				$answer_array['WENTYLACJA'] = $array[$i];
	// Вентиляция 1 слово - 2 значения :)
				$technologia = $merge_array['TECHNOLOGIA'][$answer_array['TECHNOLOGIA']];
				$wentylacja = $merge_array['WENTYLACJA'][$answer_array['WENTYLACJA']];
				if ($wentylacja == 'tuleje' OR $wentylacja == 'tuleje tworzyw.drewnopodob.') {
					if ($technologia == 'soft' OR $technologia == 'lak') {
						$answer_array['WENTYLACJA'] = 'průd'; // tuleje
					} elseif ($technologia == 'stile' OR $technologia == 'cpl' OR $technologia == 'twin') {
						$answer_array['WENTYLACJA'] = 'pp';  // tuleje tworzyw.drewnopodob.
					}
				}
			}
		}

	// // Выпиление ИЛИ Норма
	// 	if (!array_key_exists($array[$count], $merge_array['WYPEŁNIENIE'])) {
	// 		if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
	// 			$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
	// 			$answer_array['error'] = 1; 
	// 			return $answer_array;
	// 		}
	// 		$norma = true;
	// 		$answer_array['NORMA'] = $array[$count];
	// 	} else {
	// 		$answer_array['WYPEŁNIENIE'] = $array[$count];
	// 	}
	// 	$count++;

	// 	if ($count >= $lenght) return $answer_array;
	// // Норма ИЛИ SZKLENIE
	// 	if (!$norma) {
	// 		if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
	// 			$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
	// 			$answer_array['error'] = 1; 
	// 			return $answer_array;
	// 		}
	// 		$answer_array['NORMA'] = $array[$count];
	// 		$count++;
	// 	} else {
	// 		$szklenie1 = $array[$count]; // С 1го слова
	// 		$szklenie2 = ($count < $lenght) ? $szklenie1 . " " . $array[$count+1] : $szklenie1; // С 2х слов
	// 		$answer_array['SZKLENIE'] = $szklenie2;
	// 		if (!array_key_exists($szklenie2, $merge_array['SZKLENIE'])) {
	// 			if (!array_key_exists($szklenie1, $merge_array['SZKLENIE'])) {
	// 				$answer_array['message'] = 'Error! I dont know value: SZKLENIE = ' . $szklenie2;
	// 				$answer_array['error'] = 1; 
	// 				return $answer_array;
	// 			}
	// 			$answer_array['SZKLENIE'] = $szklenie1;
	// 		}
	// 	}

		return $answer_array;
	}


	/** read string of order 
	* Orders:
	* OBLOŽKOVÁ ZÁRUBEŇ 80-100 AKÁCIE CPL 70 L CZ
	* OBLOŽKOVÁ ZÁRUBEŇ 80-100 AKÁCIE FINISH 70 L CZ
	* OBLOŽKOVÁ ZÁRUBEŇ 80-100 AKÁCIE FINISH 70 L PL
	* OBLOŽKOVÁ ZÁRUBEŇ 180-200 BOROVICE BÍLÁ GR 70 L CZ
	* OBLOŽKOVÁ ZÁRUBEÒ 80-100 SV. AKÁCIE FINISH 100L CZ
	* OKZ 155-180 SONOMA GREKO 80 L CZ
	* TUNEL OKZ 80-105 BÍLÝ GREKO 70 CZ
	* TUNEL 100-120 AKÁCIE FINISH 120 CZ
	**/
	public function verify_order_zarubne($order, $merge_array)
	{
		// $array = explode(" ", $order);
		$array = preg_split('/\s+/u', $order);
		// echo "array query : <pre>" . print_r($array, true) . "</pre>"; 

		$count = 0;
		$lenght = count($array) - 1;
	// Могут быть пустыми
		$order_arr['RODZAJ'] = '';
		$order_arr['SZEROKOŚĆ'] = '';
		$order_arr['KIERUNEK'] = '';
		$order_arr['ZAKRES'] = '';
		$order_arr['KOLOR'] = '';
		$order_arr['ZAWIASY'] = '';
		$order_arr['NORMA'] = '';
		$order_arr['OPASKA KĄTOWNIKA'] = '';
		$answer_array['error'] = 0;

		$order_arr['TECHNOLOGIA'] = '';
		$order_arr['MODEL'] = '';
		$order_arr['TYP'] = '';
		$order_arr['ZAMEK'] = '';
		$order_arr['WYPEŁNIENIE'] = '';
		$order_arr['SZKLENIE'] = '';
		$order_arr['WENTYLACJA'] = '';
		$answer_array['dvere'] = 0;



	// Тип может быть из 2х слов 'OBLOŽKOVÁ ZÁRUBEŇ'
		$type1 = $array[$count]; // С 1го слова
		$type2 = $type1 . " " . $array[$count+1]; // С 2х слов
		$answer_array['RODZAJ'] = $type2;
		$shift =2;
		if (!array_key_exists($type2, $merge_array['RODZAJ'])) {
			if (!array_key_exists($type1, $merge_array['RODZAJ'])) {
				$answer_array['message'] = 'Error! I dont know value: DVERE or RODZAJ = ' . $array[$count];
				$answer_array['error'] = 1; 
				return $answer_array;
			}
			$answer_array['RODZAJ'] = $type1;
			$shift = 1;
		}
		$count += $shift;

	// 3е или 2е слово ZAKRES  180-200
		if (!array_key_exists($array[$count], $merge_array['ZAKRES'])) {
			$answer_array['message'] = 'Error! I dont know value: ZAKRES = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['ZAKRES'] = $array[$count];
		$count++;

	// 4,5,6е слова Цвет
		$colour1 = $array[$count]; // С 1го слова
		$colour2 = $colour1 . " " . $array[$count+1]; // С 2х слов
		$colour3 = $colour2 . " " . $array[$count+2]; // С 3х слов
		$shift =3;
		$answer_array['KOLOR'] = $colour3;
		if (!array_key_exists($colour3, $merge_array['KOLOR'])) {
			if (!array_key_exists($colour2, $merge_array['KOLOR'])) {
				if (!array_key_exists($colour1, $merge_array['KOLOR'])) {
					$answer_array['message'] = 'Error! I dont know value: KOLOR = ' . $colour1;
					$answer_array['error'] = 1; 
					return $answer_array;
				}
				$answer_array['KOLOR'] = $colour1;
				$shift = 1;
			}
			if ($answer_array['KOLOR'] != $colour1) {
				$answer_array['KOLOR'] = $colour2;
				$shift = 2;
			}
		}
		$count += $shift;
	// Тип последнее слово в цвете
		$exploded = explode(" ", $answer_array['KOLOR']);
		$type_from_color = $answer_array['RODZAJ'] . ' ' . array_pop($exploded);
		$type_after_color = $answer_array['RODZAJ'] . ' ' . $array[$count];
		if (array_key_exists($type_from_color, $merge_array['RODZAJ'])) {
			$answer_array['RODZAJ'] = $type_from_color;
		} elseif (array_key_exists($type_after_color, $merge_array['RODZAJ'])) {
			$answer_array['RODZAJ'] = $type_after_color;
			$count++;
		}

	// 5 или 6 или 7 слово Ширина
		// Ширина и Направление - одним словом
		if (array_key_exists($array[$count], $merge_array['widePlusDirection'])) {
			$answer_array['SZEROKOŚĆ'] = $merge_array['widePlusDirection'][$array[$count]]['wide'];
			$answer_array['KIERUNEK']  = $merge_array['widePlusDirection'][$array[$count]]['direction'];
			$count++;
		} else {
			if (!array_key_exists($array[$count], $merge_array['SZEROKOŚĆ'])) {
				$answer_array['message'] = 'Error! I dont know value: SZEROKOŚĆ = ' . $array[$count];
				$answer_array['error'] = 1; 
				return $answer_array;
			}
			$answer_array['SZEROKOŚĆ'] = $array[$count];
			$count++;
		}

	// Левый/Правый ИЛИ Норма
		$norma = false;
		if (!array_key_exists($array[$count], $merge_array['KIERUNEK'])) {
			if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
				$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
				$answer_array['error'] = 1; 
				return $answer_array;
			}
			$norma = true;
			$answer_array['NORMA'] = $array[$count];
		} else {
			$answer_array['KIERUNEK'] = $array[$count];
		}
		$count++;

		if ($count > $lenght) return $answer_array;

	// Норма ИЛИ ZAWIASY ?? Если они идут после NORMA
		if (array_key_exists($array[$count], $merge_array['ZAWIASY'])) {
			$answer_array['ZAWIASY'] = $array[$count];
			$count++;
		}



		if (!$norma) {
			if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
				$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
				$answer_array['error'] = 1; 
				return $answer_array;
			}
			$answer_array['NORMA'] = $array[$count];
		}

			$count++;

	// OPASKA KĄTOWNIKA

		if (array_key_exists($array[$count], $merge_array['OPASKA KĄTOWNIKA'])) {
			$answer_array['OPASKA KĄTOWNIKA'] = $array[$count];
			$count++;
		}	


		return $answer_array;
	}

	public function verify_order_nadprazi($order, $merge_array)
	{
		// $array = explode(" ", $order); //В 1м заказе было 2 пробела
		$array = preg_split('/\s+/u', $order);
		// echo "array query : <pre>" . print_r($array, true) . "</pre>"; 
		// exit();
		$count = 0;
		$lenght = count($array) - 1;
	// Могут быть пустыми
		$order_arr['NORMA'] = '';
		$order_arr['RODZAJ / TYP'] = '';
		$order_arr['SZEROKOŚĆ'] = '';
		$order_arr['ZAKRES'] = '';
		$order_arr['KOLOR'] = '';
		$order_arr['ILOŚĆ SZTUK'] = '';
		$answer_array['error'] = 0;
		$answer_array['nadprazi'] = 0;

	// 1е слово
		if ($array[$count] != 'NADPRAŽÍ' && $array[$count] != 'NADPRAŽI') {
			$answer_array['message'] = 'Error! I dont know value: NADPRAŽÍ = ' . $array[$count];
			$answer_array['error'] = 1;
			$answer_array['nadprazi'] = 1;

			return $answer_array;
		}
		$count++;	

	// 2е слово ZAKRES  80-100
		if (!array_key_exists($array[$count], $merge_array['ZAKRES'])) {
			$answer_array['message'] = 'Error! I dont know value: ZAKRES = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['ZAKRES'] = $array[$count];
		$count++;

		// 3,4,5е слова Цвет
		$colour1 = $array[$count]; // С 1го слова AKACIE
		$colour2 = $colour1 . " " . $array[$count+1]; // С 2х слов AKACIE FINISH
		$colour3 = $colour2 . " " . $array[$count+2]; // С 3х слов

		$shift = 3;
		$answer_array['KOLOR'] = $colour3;

		//echo $colour3 . "<br>";
		//echo "<pre>" .print_r($merge_array['KOLOR'], true). "</pre>";	
		//exit();

		if (!array_key_exists($colour3, $merge_array['KOLOR'])) {


			if (!array_key_exists($colour2, $merge_array['KOLOR'])) {

				if (!array_key_exists($colour1, $merge_array['KOLOR'])) {
					$answer_array['message'] = 'Error! I dont know value: KOLOR = ' . $colour1;
					$answer_array['error'] = 1; 
					return $answer_array;
				}
				$answer_array['KOLOR'] = $colour1;
				$shift = 1;
			}
			if ($answer_array['KOLOR'] != $colour1) {
				$answer_array['KOLOR'] = $colour2;
				$shift = 2;
			}
		}
		$count += $shift;




		// SZEROKOŚĆ
		$array[$count]=str_replace('"','',$array[$count]);
		if (!array_key_exists($array[$count], $merge_array['SZEROKOŚĆ'])) {
			$answer_array['message'] = 'Error! I dont know value: SZEROKOŚĆ = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['SZEROKOŚĆ'] = $array[$count];
		$count++;

		// Норма
		if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
			$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['NORMA'] = $array[$count];
		$count++;


		return $answer_array;
	}

	public function verify_order_stojiny($order, $merge_array)
	{
		// $array = explode(" ", $order); //В 1м заказе было 2 пробела
		$array = preg_split('/\s+/u', $order);
		// echo "array query : <pre>" . print_r($array, true) . "</pre>"; 
		// exit();
		$count = 0;
		$lenght = count($array) - 1;
	// Могут быть пустыми
		$order_arr['NORMA'] = '';
		$order_arr['RODZAJ / TYP'] = '';
		$order_arr['KIERUNEK'] = '';
		$order_arr['ZAKRES'] = '';
		$order_arr['KOLOR'] = '';
		$order_arr['ILOŚĆ SZTUK'] = '';
		$answer_array['error'] = 0;
		$answer_array['nadprazi'] = 0;

	// 1е слово
		if ($array[$count] != 'STOJINY') {
			$answer_array['message'] = 'Error! I dont know value: STOJINY = ' . $array[$count];
			$answer_array['error'] = 1;
			$answer_array['nadprazi'] = 1;

			return $answer_array;
		}
		$count++;	

	// 2е слово ZAKRES  80-100
		if (!array_key_exists($array[$count], $merge_array['ZAKRES'])) {
			$answer_array['message'] = 'Error! I dont know value: ZAKRES = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['ZAKRES'] = $array[$count];
		$count++;

		// 3,4,5е слова Цвет
		$colour1 = $array[$count]; // С 1го слова AKACIE
		$colour2 = $colour1 . " " . $array[$count+1]; // С 2х слов AKACIE FINISH
		$colour3 = $colour2 . " " . $array[$count+2]; // С 3х слов

		$shift = 3;
		$answer_array['KOLOR'] = $colour3;

		//echo $colour3 . "<br>";
		//echo "<pre>" .print_r($merge_array['KOLOR'], true). "</pre>";	
		//exit();

		if (!array_key_exists($colour3, $merge_array['KOLOR'])) {


			if (!array_key_exists($colour2, $merge_array['KOLOR'])) {

				if (!array_key_exists($colour1, $merge_array['KOLOR'])) {
					$answer_array['message'] = 'Error! I dont know value: KOLOR = ' . $colour1;
					$answer_array['error'] = 1; 
					return $answer_array;
				}
				$answer_array['KOLOR'] = $colour1;
				$shift = 1;
			}
			if ($answer_array['KOLOR'] != $colour1) {
				$answer_array['KOLOR'] = $colour2;
				$shift = 2;
			}
		}
		$count += $shift;




		// KIERUNEK
		$array[$count]=str_replace('"','',$array[$count]);
		if (!array_key_exists($array[$count], $merge_array['KIERUNEK'])) {
			$answer_array['message'] = 'Error! I dont know value: KIERUNEK = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['KIERUNEK'] = $array[$count];
		$count++;

		// Норма
		if (!array_key_exists($array[$count], $merge_array['NORMA'])) {
			$answer_array['message'] = 'Error! I dont know value: NORMA = ' . $array[$count];
			$answer_array['error'] = 1; 
			return $answer_array;
		}
		$answer_array['NORMA'] = $array[$count];
		$count++;


		return $answer_array;
	}
	
	
	
	
	
	
	
	
	
	
}
