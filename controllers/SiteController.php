<?php

namespace app\controllers;

use Yii;
use DOMDocument;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Zakazniky;
use app\models\ZakaznikySkupina;
use app\models\Seznam;
use app\models\Nabidky;
use app\models\Category;
use app\models\Typ;
use app\models\Norma;
use app\models\Modely;
use app\models\ModelyOdstin;
use app\models\Odstin;
use app\models\Rozmer;
use app\models\Otevirani;
use app\models\Typzamku;
use app\models\Vypln;
use app\models\Ventilace;
use app\models\Map;
use app\models\DvereErkado;
use app\models\Countries;
use app\models\CenovaHladina;
use yii\web\UploadedFile;
use app\models\Moneys;
use app\models\CenikySeznam;
use app\models\SkladySeznam;
use app\models\Log;
use app\models\Rada;
use app\models\PriplatekOptions;

use \thamtech\uuid\helpers\UuidHelper;

use yii\db\Query;
use mPDF;
use yii\helpers\Json;
use SoapClient;

class SiteController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest)
		{
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login())
		{
			//return $this->goBack();
			return $this->redirect(Yii::$app->request->referrer);
		}
		return $this->render('login', [
				'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	/*
	  public function actionLogout()
	  {
	  Yii::$app->user->logout();

	  return $this->goHome();
	  }
	 */

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->redirect(Yii::$app->user->loginUrl);
	}

	public function beforeAction($action)
	{


		if (parent::beforeAction($action))
		{
			// change layout for error action
			if ($action->id == 'login')
				$this->layout = 'login';
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	  public function beforeAction()
	  {
	  if (Yii::app()->user->isGuest)
	  $this->redirect(Yii::app()->createUrl('user/login'));

	  //something code right here if user valided
	  }
	 */

	/**
	 * Displays contact page.
	 *
	 * @return string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail']))
		{
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
				'model' => $model,
		]);
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionSettings()
	{
		return $this->render('settings');
	}

	public function actionMoneys()
	{
		
		$newid = UuidHelper::uuid(); // ID
		
		$connection = Moneys::getDb();
		$command = $connection->createCommand("
		INSERT INTO System_XmlExchangeImport
           ([ID]
           ,[Parent_ID]
           ,[Root_ID]
           ,[Group_ID]
           ,[Deleted]
           ,[Hidden]
           ,[Locked]
           ,[Create_ID]
           ,[Create_Date]
           ,[Modify_ID]
           ,[Modify_Date]
           ,[UserData]
           ,[DatumZpracovani]
           ,[KodImportu]
           ,[VstupniXml]
           ,[Report]
           ,[Stav]
           ,[Attachments])
		VALUES
           ('$newid'
           ,NULL
           ,NULL
           ,NULL
           ,0
           ,0
           ,0
           ,'32FF1F31-E780-44EC-AFDB-F62EF5C4CDC7'
           ,GETDATE()
           ,NULL
           ,NULL
           ,NULL
           ,NULL
           ,'ESK01'
           ,'Test test test 222'
           ,NULL
           ,0
           ,0)


				");
		$result = $command->execute();
		
		
		return $this->render('about');
	}
	
	public function actionAjax()
	{
		if (Yii::$app->request->isAjax)
		{
			$dataAjax = Yii::$app->request->post();
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$id = $dataAjax['id'];

			if (strlen($dataAjax['text']) > 2)
			{
				$text = $dataAjax['text'];
			} else
			{
				$text = "ЕЎЕЎЕЎ";
			}

			$i = 1;
			$data = Seznam::getSeznam($text);
			foreach ($data as $dat)
			{
				$table_line = "<tr class='tline-" . $i . "' data-name='" . $dat['name'] . "' data-kod='" . $dat['kod'] . "' data-cena='" . $dat['cena'] . "' data-id='" . $dat['id'] . "'><td>" . $dat['id'] . "</td><td>" . $dat['name'] . "</td></tr>";
				$table = $table . $table_line;
				$i++;
			}

			$result = "<table class='table table-striped table-bordered table-polozky' data-table = '" . $id . "' style='background-color: #fff; margin-bottom: 0px !important;'> " . $table . "</table>";
			//$result = "<ul class='table table-striped table-bordered table-polozky' style='background-color: #fff; margin-bottom: 0px !important;'> " . $table . "</ul>";
		} else
		{
			$result = false;
		}
		//return $this->render('index');

		return $result;
	}

	public function actionAres()
	{
		error_reporting(0);

		header("Content-Type: application/json; charset=UTF-8");
		$url = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=';
		$ico = (int)Yii::$app->request->get('ico');
		$url = $url . $ico;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$data = curl_exec($curl);
		curl_close($curl);
		

		if ($data)
		{	
			$xml = simplexml_load_string($data);
		}
		
		$a = array();

		if (isset($xml))
		{
			$ns = $xml->getDocNamespaces();
			$data = $xml->children($ns['are']);
			$el = $data->children($ns['D'])->VBAS;
			if (strval($el->ICO) == $ico)
			{
				$a['ico'] = strval($el->ICO);
				$a['dic'] = strval($el->DIC);
				$a['firma'] = strval($el->OF);
				
				$a['jmeno'] = "";
				$a['prijmeni'] = "";
				// detekce jmГ©na a firmy ..
				$firma = $a['firma'];
				$roz = explode(" ", $firma);
				$match = preg_match("/(s\.r\.o\.|s\. r\. o\.|spol\. s r\.o\.|a\.s\.|a\. s\.|v\.o\.s|v\. o\. s\.|o\.s\.|k\.s\.|kom\.spol\.)/", $firma);
				if (count($roz) == 2 AND ! $match)
				{
					// nenaЕЎli jsme shodu s firmou, pravdД›podobnД› se jednГЎ o ЕѕivnostnГ­ka se jmГ©nem ..
					$a['jmeno'] = $roz[0];
					$a['prijmeni'] = $roz[1];
				}

				$a['ulice'] = strval($el->AA->NU);
				if (!empty($el->AA->CO) OR ! empty($el->AA->CD))
				{
					$a['ulice'] .= " ";
					if (!empty($el->AA->CD))
						$a['ulice'] .= strval($el->AA->CD);
					if (!empty($el->AA->CO) AND ! empty($el->AA->CD))
						$a['ulice'] .= "/";
					if (!empty($el->AA->CO))
						$a['ulice'] .= strval($el->AA->CO);
				}

				$a['countries'] = strval($el->AA->NS);
				$a['mesto'] = strval($el->AA->N);
				$a['psc'] = strval($el->AA->PSC);
				$a['stav'] = 'ok';
				
				// nespolehlyvy platce DPH 
				if (strlen(trim($a['dic'])) > 3)
				{
					$client = new SoapClient('http://adisrws.mfcr.cz/adistc/axis2/services/rozhraniCRPDPH.rozhraniCRPDPHSOAP');
					$platce = $client->getStatusNespolehlivyPlatce(['dic' => strval($el->DIC)])->statusPlatceDPH->nespolehlivyPlatce;
					
					if ($platce == 'NE')
					{
						$a['spolehlivy_platce_dph'] = "Ano";
					}
					else if ($platce == 'ANO')
					{
						$a['spolehlivy_platce_dph'] = "Ne";
					}
					else
					{
						$a['spolehlivy_platce_dph'] = 'Nevím';
					}
				}
				else
				{
					$a['spolehlivy_platce_dph'] = 'Nevím';
				}
				
			}
			else
			{
				$a['stav'] = 'IДЊ firmy nebylo v databГЎzi ARES nalezeno';
			}
		}
		else
		{
			$a['stav'] = 'DatabГЎze ARES nenГ­ dostupnГЎ';
		}

		return json_encode($a);
	}

	public function actionLog()
	{
		error_reporting(0);

		header("Content-Type: application/json; charset=UTF-8");
		$id = (int) Yii::$app->request->get('id');
		$controller = Yii::$app->request->get('controller');

		$l['id'] = $id;
		$l['controller'] = $controller;

		//$data = Log::find()->select('user.name name, log.message, log.ip, log.datetime')->leftJoin('user', 'log.user_id = user.id')->andWhere('log.controller_name = :ctr',[':ctr' => $controller])->andWhere('log.item_id = :itm',[':itm' => $id])->all();

		$query = new Query;
		$query->select('u.name name, l.message, l.ip, l.datetime')
			->from('log l')
			->leftJoin('user u', 'u.id = l.user_id')
			->andWhere('l.controller_name = :ctr', [':ctr' => $controller])
			->andWhere('l.item_id = :itm', [':itm' => $id])
			->orderBy('l.id DESC');

		$command = $query->createCommand();
		$data = $command->queryAll();


		$t = "";
		$ii = count($data);
		foreach ($data as $dat)
		{
			$time = date('d.m.Y H:i:s', strtotime($dat['datetime']));
			$t1 = "<tr><td>{$ii}</td><td>{$dat['name']}</td><td>{$dat['message']}</td><td>{$dat['ip']}</td><td>{$time}</td></tr>";
			$t = $t . $t1;
			$ii--;
		}

		$table_head = "<table class='table table-striped table-bordered'>"
			. "<thead>"
			. "<tr>"
			. "<th>ID</th>"
			. "<th>Uživatel</th>"
			. "<th>Zpráva</th>"
			. "<th>IP</th>"
			. "<th>Čas</th>"
			. "</tr>"
			. "</thead>"
			. "<tbody>";

		$table_foot = "</tbody>"
			. "</table>";

		$table = $table_head . $t . $table_foot;

		$arr = array('table' => $table);
		//print_r($arr);
		//exit();
		echo json_encode($arr);
	}
	
	public function actionCheck()
	{
		error_reporting(0);

		header("Content-Type: application/json; charset=UTF-8");
		$ico = (int) Yii::$app->request->get('ico');
		$idz = (int) Yii::$app->request->get('idz'); // 100
		
		$zakazniky = Zakazniky::find()->where(['ico' => $ico])->one();
		$a['id'] = $zakazniky->id;
		$a['name'] = $zakazniky->o_name;
		
		if ($zakazniky->id <> $idz)
		{
			$a['count'] = count($zakazniky);
		}
		else
		{
			$a['count'] = 0;
		}
		return json_encode($a);
	}
	
	public function actionPlatce()
	{
		error_reporting(0);

		header("Content-Type: application/json; charset=UTF-8");
		$dic = (int) preg_replace('~[^0-9]+~', '', Yii::$app->request->get('dic'));
		
		if (strlen(trim($dic)) > 3)
		{
			$client = new SoapClient('http://adisrws.mfcr.cz/adistc/axis2/services/rozhraniCRPDPH.rozhraniCRPDPHSOAP');
			$platce = $client->getStatusNespolehlivyPlatce(['dic' => $dic])->statusPlatceDPH->nespolehlivyPlatce;

			if ($platce == 'NE')
			{
				$a['spolehlivy_platce_dph'] = "Ano";
			}
			else if ($platce == 'ANO')
			{
				$a['spolehlivy_platce_dph'] = "Ne";
			}
			else
			{
				$a['spolehlivy_platce_dph'] = 'Nevím';
			}
		}
		else
		{
			$a['spolehlivy_platce_dph'] = 'Nevím 2';
		}

		return json_encode($a);
	}
	
	public function createDirectory($path)
	{
		//$filename = "/folder/{$dirname}/";  
		if (file_exists($path))
		{
			//echo "The directory {$path} exists";  
		} else
		{
			mkdir($path, 0775, true);
			//echo "The directory {$path} was successfully created.";  
		}
	}

	// Privacy statement output demo
	public function actionMpdfDemo1()
	{
		// https://mpdf.github.io/

		$mpdf = new mPDF();
		$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
		$mpdf->SetFooter('Document Title');
		$mpdf->defaultheaderfontsize = 10;
		$mpdf->defaultheaderfontstyle = 'B';
		$mpdf->defaultheaderline = 0;
		$mpdf->defaultfooterfontsize = 10;
		$mpdf->defaultfooterfontstyle = 'BI';
		$mpdf->defaultfooterline = 0;
		$mpdf->WriteHTML('Document text');
		$mpdf->Output('MyPDF.pdf', 'D');
		exit;

	}
	
	public function actionModely()
	{
		$out = [];
		if (filter_has_var(INPUT_POST, 'depdrop_parents'))
		{
			$id = end($_POST['depdrop_parents']); // rada id
			$list = Modely::find()->andWhere(['rada_id' => $id])->asArray()->all();
			$selected = null;
			if ($id != null && count($list) > 0)
			{
				$selected = '';
				foreach ($list as $i => $account)
				{
					$name = Modely::findOne($account['id']);
					$out[] = ['id' => $account['id'], 'name' => $name['name'] . ' (+' . $name['cena'] . ' Kč)'];
				}

				// Shows how you can preselect a value
				return Json::encode(['output' => $out, 'selected' => '']);
				return;
			}
		}
		return Json::encode(['output' => '', 'selected' => '']);
	}
	
	public function actionOdstiny()
	{
		$out = [];
		if (filter_has_var(INPUT_POST, 'depdrop_parents'))
		{
			$id = end($_POST['depdrop_parents']); // modely id
			$list = ModelyOdstin::find()->andWhere(['modely_id' => $id])->asArray()->all();
			$selected = null;
			if ($id != null && count($list) > 0)
			{
				$selected = '';
				foreach ($list as $i => $account)
				{
					$name = Odstin::find()->where(['id' => $account['odstin_id']])->one();
					
					$cf = ModelyOdstin::find()->andWhere(['modely_id' => $id, 'odstin_id' => $account['odstin_id']])->one();
					
					$out[] = ['id' => $account['odstin_id'], 'name' => $name['name'] . ' (+' . $cf['cena_odstin'] . ' Kč)'];
				}

				// Shows how you can preselect a value
				return Json::encode(['output' => $out, 'selected' => '']);
				return;
			}
		}
		return Json::encode(['output' => '', 'selected' => '']);
	}
	
	public function actionRada()
	{
		$id_rd = (int) Yii::$app->request->get('id_rd'); // 2
		$rada = Rada::findOne($id_rd);
		
		$dodavatele = Zakazniky::findOne($rada->zakazniky_id);
		$result['dodavatele_id'] = $rada->zakazniky_id;
		$result['dodavatele_name'] = $dodavatele->o_name;
		
		return json_encode($result);
	}

	public function actionCena()
	{
		$id_t = (int) Yii::$app->request->get('id_t'); // 2
		$id_n = (int) Yii::$app->request->get('id_n'); // 2
		$id_m = (int) Yii::$app->request->get('id_m'); // 2
		$id_o = (int) Yii::$app->request->get('id_o'); // 1
		$id_r = (int) Yii::$app->request->get('id_r'); // 1
		$id_ot = (int) Yii::$app->request->get('id_ot'); // 1
		$id_tz = (int) Yii::$app->request->get('id_tz'); // 1
		$id_v = (int) Yii::$app->request->get('id_v'); // 1
		$id_vt = (int) Yii::$app->request->get('id_vt'); // 1
		$cpa = Yii::$app->request->get('cpa'); // 1
		
		//$cena_bez_dph = (int)Yii::$app->request->get('cena_bez_dph'); // 2
		//$cena_s_dph = (int)Yii::$app->request->get('cena_s_dph'); // 2

		if ($id_t > 0)
		{
			$typ = Typ::findOne($id_t);
			//$result['cena_n'] = $norma['cena'];
			$result['typ1'] = $typ['name'];
		} 
		else
		{
			$result['typ1'] = '';
			$result['cena_v'] = 0;
		}

		if ($id_n > 0)
		{
			$norma = Norma::findOne($id_n);
			//$result['cena_n'] = $norma['cena'];
			$result['norma1'] = $norma['zkratka'];
		} 
		else
		{
			$result['norma1'] = '';
			$result['cena_v'] = 0;
		}

		if ($id_m > 0)
		{
			$model = Modely::findOne($id_m);
			$result['cena_m'] = $model['cena'];

			$rada_id = $model['rada_id'];


			$result['model1'] = $model['name'];
			
			if ($rada_id <> 1) // ne rada STANDARD
			{
				$result['vypln1'] = '';
				$result['vypln1_div'] = 0;
			}
			
		} 
		else
		{
			$result['model1'] = '';
			$result['cena_m'] = 0;
		}

		if ($id_o > 0)
		{
			$modstin = ModelyOdstin::find()->where(['modely_id' => $id_m, 'odstin_id' => $id_o])->one();
			$result['cena_o'] = $modstin['cena_odstin'];

			$odstin = Odstin::find()->where(['id' => $id_o])->one();
			$result['odstin1'] = $odstin['name'];
		} 
		else
		{
			$result['odstin1'] = '';
			$result['cena_o'] = 0;
		}

		if ($id_r > 0)
		{
			$rozmer = Rozmer::find()->where(['id' => $id_r])->one();
			$result['cena_r'] = $rozmer['cena'];

			$result['rozmer1'] = $rozmer['name'];
		} 
		else
		{
			$result['rozmer1'] = '';
			$result['cena_r'] = 0;
		}

		if ($id_ot > 0)
		{
			$otevirani = Otevirani::find()->where(['id' => $id_ot])->one();
			//$result['cena_n'] = $norma['cena'];
			$result['otevirani1'] = $otevirani['zkratka'];
		} 
		else
		{
			$result['otevirani1'] = '';
		}

		if ($id_tz > 0)
		{
			$typzamku = Typzamku::find()->where(['id' => $id_tz])->one();
			//$result['cena_n'] = $norma['cena'];
			$result['typzamku1'] = $typzamku['zkratka'];
		} 
		else
		{
			$result['typzamku1'] = '';
		}


		if ($id_v > 0)
		{
			$vypln = Vypln::find()->where(['id' => $id_v])->one();
			$result['cena_v'] = $vypln['cena'];
			$result['zkratka'] = $vypln['zkratka'];

			$result['vypln1'] = $vypln['zkratka'];

			if ($rada_id <> 1) // ne rada STANDARD
			{
				$result['vypln1'] = '';
				$result['vypln1_div'] = 0;
			}
		} 
		else
		{
			$result['vypln1'] = '';
			$result['cena_v'] = 0;
		}

		if ($id_vt > 0)
		{
			$ventilace = Ventilace::find()->where(['id' => $id_vt])->one();
			$result['cena_vt'] = $ventilace['cena'];
			$result['zkratka2'] = $ventilace['zkratka'];

			$result['ventilace1'] = $ventilace['zkratka'];
		} 
		else
		{
			$result['ventilace1'] = '';
			$result['cena_vt'] = 0;
		}
		

		//$items = explode(',', $cpa);
		
		//$items = array();
		
		$result['cena_itm'] = 0;
		$result['cpa'] = '';
		
		if(count($cpa) > 0)
		{
			for($ii=0; $ii<count($cpa); $ii++)
			{
				if ($cpa[$ii] > 0)
				{
					$idd = $cpa[$ii];
					$itm = PriplatekOptions::findOne($idd);
					$result['cena_itm'] = (int)$result['cena_itm'] + (int)$itm->cena;

					$result['cpa'] = $result['cpa'] . ' ' . $itm->zkratka;
				}	
			}
		}
		
		//$result['cena_itm'] = 0;
		
		
		$result['cena_bez_dph'] = $result['cena_m'] + $result['cena_o'] + $result['cena_r'] + $result['cena_v'] + $result['cena_vt'] + $result['cena_itm'];
		//$result['cena_bez_dph'] = $cpa;

		//$result['cena_s_dph'] = round($result['cena_bez_dph'] + ($result['cena_bez_dph'] * 21 / 100));

		// name
		$result['name'] = $result['typ1'] . ' ' . $result['model1'] . ' ' . $result['rozmer1'] . ' ' . $result['otevirani1'] . ' ' . $result['odstin1'] . ' ' . $result['typzamku1'] . ' ' . $result['vypln1'] . ' ' . $result['ventilace1'] . ' ' . $result['cpa'] . ' ' . $result['norma1'];
		$result['name'] = str_replace("-", "", $result['name']);
		$result['name'] = preg_replace('/[\s]{2,}/', ' ', $result['name']); // двойные пробелы
		//$result['name'] = str.replace(/\s+/g,' ');
		
		//$result['name'] = $items2;

		return json_encode($result);
	}

	public function actionNorma()
	{
		$norma_id = (int) Yii::$app->request->get('norma_id'); // 2

		if ($norma_id > 0)
		{
			$norma = Norma::find()->where(['id' => $norma_id])->one();
			$result['zkratka'] = $norma['zkratka'];
		}

		return json_encode($result);
	}
	
	public function actionChladina()
	{
		$idz = (int) Yii::$app->request->get('id'); // 2

		if ($idz > 0)
		{
			$chladina = Zakazniky::findOne($idz);
			$arr = json_decode($chladina['c_hladina']);
			
			if (count($arr) >0)
			{	
				$res = '';
				foreach($arr as $ch)
				{
					$chl = CenovaHladina::findOne($ch);
					$res = $res  . "<span class='label label-success' style='font-size: 14px; margin-right: 10px;'>" . $chl['name'] . "</span>";
				}
			}
			else
			{
				$res = "---";
			}
		}

		return json_encode($res);
	}
	
	public function actionChladinaModely()
	{
		$ids = (int) Yii::$app->request->get('ids'); // 2
		$idz = (int) Yii::$app->request->get('idz'); // 2
		$cena = (int) Yii::$app->request->get('cena'); // 2
		$modalpolozkaid = (int) Yii::$app->request->get('modalpolozkaid'); // 2
		
		if ($ids > 0)
		{
			$modely = Seznam::find()->where(['id' => $ids])->one();
			$modely_id = $modely['modely_id'];
			
			$chladina = Modely::find()->where(['id' => $modely_id])->one();
			$arr = json_decode($chladina['c_hladina']);
			
			if (count($arr) >0)
			{	
				$res = '';
				foreach($arr as $ch)
				{
					$chl = CenovaHladina::find()->where(['id' => $ch])->one();
					$res = $res  . "<span class='label label-success' style='font-size: 14px; margin-right: 10px;'>" . $chl['name'] . "</span>";
				}
			}
			else
			{
				$res = "---";
			}
			
			$data['res'] = $res;
			$data['modalpolozkaid'] = $modalpolozkaid;
			

			// cena
			if ($idz > 0)
			{
				$data['procent'] = $this->procentChladina($modely_id, $idz);
				$data['cena'] = $cena*(100-$data['procent'])/100;
			}
			else
			{
				$data['cena'] = $cena;
			}
			

		}

		return json_encode($data);
	}
	
	public function procentChladina($idm, $idz)
	{
		$chm = Modely::find()->where(['id' => $idm])->one();
		$arr_modely = json_decode($chm['c_hladina']); // massiv c_hladina modely

		if (count($arr_modely) >0)
		{	
			foreach($arr_modely as $ch1)
			{
				$chl = \app\models\CenovaHladina::find()->where(['id' => $ch1])->one();
				$mass_modely[] = $chl['procent'];
			}
		}
		else
		{
			$mass_modely = array();
		}
		
		$chz = Zakazniky::find()->where(['id' => $idz])->one();
		$arr_zakazniky = json_decode($chz['c_hladina']); // massiv c_hladina zakazniky
		
		$mass_zakazniky = array();
		if (count($arr_zakazniky) >0)
		{	
			foreach($arr_zakazniky as $ch2)
			{
				$ch2 = CenovaHladina::find()->where(['id' => $ch2])->one();
				$mass_zakazniky[] = $ch2['procent'];
			}
		}
		else
		{
			$mass_modely = array();
		}

		$arr_result = array_intersect($mass_modely, $mass_zakazniky);

		if (count($arr_result) > 0 )
		{
			$procent = max($arr_result);
		}
		else
		{
			$procent = 0;
		}

		return $procent;
	}
	
	public function actionChladinaCount()
	{
		$idz = (int) Yii::$app->request->get('idz'); // 2
		//$count = (int) Yii::$app->request->get('count'); // 2
		$arr = Yii::$app->request->get('arr'); // 
		$obj = json_decode($arr);

		foreach ($obj as $row)
		{
			
			$i = (int)$row->i; $i = $i*1; // id polozky
			$ids = $row->ids;
			$res[$i] = $row->ids; // id seznam
			
			$seznam = Seznam::findOne($ids);
			$cs = CenikySeznam::find()->where(['seznam_id' => $ids])->one();
			
			$cena_bez_dph = $cs->cena; // cena seznam
			$modely_id = $seznam['modely_id'];
			
			// modely
			$chladina = Modely::findOne($modely_id);
			$arr = json_decode($chladina['c_hladina']);
			
			$mass_modely = array();
			
			if (count($arr) >0)
			{	
				foreach($arr as $ch)
				{
					$chl = CenovaHladina::findOne($ch);
					$mass_modely[] = $chl['procent'];
				}
			}
			else
			{
				$mass_modely = array();
			}
			
			// zakaznik
			$chladinaZ = Zakazniky::findOne($idz);
			$arrZ = json_decode($chladinaZ['c_hladina']);
			
			$mass_zakazniky = array();
			
			if (count($arrZ) > 0)
			{	
				foreach($arrZ as $ch)
				{
					$chl = CenovaHladina::findOne($ch);
					$mass_zakazniky[] = $chl['procent'];
				}
			}
			else
			{
				$mass_zakazniky = array();
			}
			
			$arr_result = array_intersect($mass_modely, $mass_zakazniky);
			
			if (count($arr_result) > 0 )
			{
				$procent = max($arr_result);
			}
			else
			{
				$procent = 0;
			}
			
			$new_cena_bez_dph = $cena_bez_dph * (100 - $procent) / 100;
			
			$i = (int)$row->i; $i = $i*1; // id polozky
			$res[$i] = $new_cena_bez_dph; // id seznam
		
		}
		
		return json_encode($res);
		
	}
	
	public function actionKonstrukter()
	{
		$data['polozka_id'] = (int) Yii::$app->request->get('polozka_id');
		$data['name'] = Yii::$app->request->get('name');
		$data['typ_id'] = Yii::$app->request->get('typ_id');
		$data['norma_id'] = Yii::$app->request->get('norma_id');
		$data['modely_id'] = Yii::$app->request->get('modely_id');
		$data['odstin_id'] = Yii::$app->request->get('odstin_id');
		$data['rozmer_id'] = Yii::$app->request->get('rozmer_id');
		$data['otevirani_id'] = Yii::$app->request->get('otevirani_id');
		$data['typzamku_id'] = Yii::$app->request->get('typzamku_id');
		$data['vypln_id'] = Yii::$app->request->get('vypln_id');
		$data['ventilace_id'] = Yii::$app->request->get('ventilace_id');
		
		$data['zakazniky_id'] = Yii::$app->request->get('zakazniky_id'); // Dodavatel
		$data['category_id'] = Category::getCategoryId($data['name']);
		
		$data['carovy_kod'] = Yii::$app->request->get('carovy_kod');
				
		$data['jednotka_id'] = Yii::$app->request->get('jednotka_id');
		$data['hmotnost'] = Yii::$app->request->get('hmotnost');
		$data['dodaci_lhuta'] = Yii::$app->request->get('dodaci_lhuta');
		
		$dat = Seznam::insertSeznam($data);

		
		// CenikySeznam
		$data2['ceniky_id'] = Yii::$app->request->get('ceniky_id');
		$data2['cena'] = Yii::$app->request->get('cena');
		$data2['typceny_id'] = 1;
		$data2['seznam_id'] = $dat['id'];
		
		$dat2 = CenikySeznam::insertCenikySeznam($data2);
		
		// SkladySeznam
		$data3['sklady_id'] = Yii::$app->request->get('sklady_id');
		$data3['seznam_id'] = $dat['id'];
		$data3['zasoba_pojistna'] = Yii::$app->request->get('zasoba_pojistna');
		
		$dat3 = SkladySeznam::insertSkladySeznam($data3);

		
		$dat['nabidky-zakazniky_id'] = Yii::$app->request->get('nabidky_zakazniky_id');
		
		$data['insert_id'] = $dat['id'];
		$data['kod'] = $dat['kod'];
		
		if ($dat['nabidky-zakazniky_id'] > 0)
		{
			$data['procent'] = $this->procentChladina($data['modely_id'], $dat['nabidky-zakazniky_id']);
			$data['cena_bez_dph'] = $data2['cena'] * (100-$data['procent'])/100;
		}
		else
		{
			$data['cena_bez_dph'] = $data2['cena'];
		}
		
		return json_encode($data);
	}
	
	public function actionSeznamCount()
	{
		$idn = Yii::$app->request->get('idn'); // ID Nabidky
		$nabidka = Nabidky::findOne($idn);
		$faktura_vydana = $nabidka->faktura_vydana;
		$dlist_vydany = $nabidka->dlist_vydany;
		
		$arr = Yii::$app->request->get('arr'); // 
		$obj = json_decode($arr);
		$i = 0;
		
		foreach ($obj as $row)
		{
			$ids = $row->ids;
			$pocet = $row->pocet;
			
			$seznam = Seznam::find()->where(['id' => $ids])->one();
			$pocet_sklad = $seznam['stav'];
			
			$pocet_all = (int)$pocet_sklad - (int)$pocet;
			if($pocet_all >= 0)
			{
				$data[] = 1;
			}
			else
			{
				$data[] = 0;
			}
			$i++;
		}
		
		if(array_sum($data) == $i)
		{
			$result = 1;
		}
		else
		{
			$result = 0;
		}
		
		if ($faktura_vydana == 1 || $dlist_vydany == 1)
		{
			$result = 1;
		}
		
		echo json_encode($result);
		
	}
	
	public function actionZakaznikyList($q = null, $id = null)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!is_null($q))
		{
			$query = new Query;
			$query->select('id, o_name AS text')
				->from('zakazniky')
				->where(['like', 'o_name', $q])
				->limit(20);
			$command = $query->createCommand();
			$data = $command->queryAll();
			$out['results'] = array_values($data);
		}
		elseif ($id > 0)
		{
			$out['results'] = ['id' => $id, 'text' => Zalazniky::find($id)->o_name];
		}
		return $out;
	}
	
	public function actionMap2($zakazka)
    {
        if(Yii::$app->request->post())
		{
			$zakazka = Yii::$app->request->post('zakazka');
			
			return $this->redirect(['map?zakazka=' . $zakazka]);
		}
		
		
		$mapy = Map::find()->where(['zakazka'=>$zakazka])->all();
		
		foreach($mapy as $map)
		{
			$maps[] = array('location' => [
                'city' => $map->city,
				'address' => $map->address,
				'postalCode' => $map->postalCode,
				'country' => 'Česká republika',
            ],
            'htmlContent' => $map->htmlContent);
		}
		
		return $this->render('map',
			[
				'maps' => $maps
			]
		);
    }
	
	public function actionMapUpload()
    {
		if (Yii::$app->request->isPost) 
		{
			$file = UploadedFile::getInstanceByName('file');
			if ($file)
			{
				//$model->file = $file;
				//if ($model->validate(['file']))
				//{
					$dir = Yii::getAlias('images/xml/');
					$fileName = $file->baseName . '.' . $file->extension;
					$file->saveAs($dir . $fileName);
					$file = $fileName;

				//}
			}
		}
		
		
		return $this->render('map-upload');
	}
	
	public function actionZakaznikyDe()
	{
		$max_order_id = Zakazniky::find()->max('order_id');
		
		if ($max_order_id > 0)
		{
			$max_order_id = $max_order_id;
		}
		else
		{
			$max_order_id = 0;
		}
		
		//$allOrders = DvereErkado::getAllOrders(50);
		$allOrders = DvereErkado::getAllMaxOrders($max_order_id);
		
		foreach ($allOrders as $all)
		{
			$order_id = $all['order_id'];
			$findCount = Zakazniky::find()->where(['order_id'=> $order_id])->all();
			$count = count($findCount);
			
			if($count == 0)
			{
				$zakazniky = new Zakazniky;
				$zakazniky->order_id = $all['order_id'];


				$zakazniky->uuid = Moneys::createID();
				
				$zakazniky->zakazniky_skupina_id = 4;
				$zskupina = ZakaznikySkupina::FindOne($zakazniky->zakazniky_skupina_id);
				$uuid_zs = $zskupina->uuid;

				if(strlen(trim($all['payment_company'])) > 2)
				{
					$o_name = $all['payment_company'];
				}
				else
				{
					$o_name = $all['payment_firstname'] . " " . $all['payment_lastname'];
				}
				$zakazniky->o_name = $o_name;

				$zakazniky->uuid_phone = Moneys::createID();
				$zakazniky->phone = trim(str_replace(" ", "", $all['telephone']));
				$zakazniky->uuid_email = Moneys::createID();
				$zakazniky->email = $all['email'];

				if(strlen(trim($all['payment_address_2'])) > 2)
				{
					$zakazniky->ico = $all['payment_address_2'];
				}

				$zakazniky->uuid_kontaktni_osoba = Moneys::createID();
				$zakazniky->kontaktni_osoba = $all['payment_firstname'] . " " . $all['payment_lastname'];
				$zakazniky->o_ulice = $all['payment_address_1'];
				$zakazniky->o_mesto = $all['payment_city'];
				$zakazniky->o_psc = $all['payment_postcode'];
				
				$zakazniky->o_countries_id = Countries::getId($all['payment_country']);
				$o_country = Countries::FindOne($zakazniky->o_countries_id);
				$o_cname = $o_country->name;

				$zakazniky->is_fa = 1;
				$zakazniky->f_name = $zakazniky->o_name;
				$zakazniky->f_mesto = $zakazniky->o_mesto;
				$zakazniky->f_ulice = $zakazniky->o_ulice;
				$zakazniky->f_psc = $zakazniky->o_psc;
				$zakazniky->f_countries_id = $zakazniky->o_countries_id;
				$f_country = Countries::FindOne($zakazniky->f_countries_id);
				$f_cname = $f_country->name;

				$zakazniky->is_pa = 1;

				if(strlen(trim($all['shipping_company'])) > 2)
				{
					$p_name = $all['shipping_company'];
				}
				else
				{
					$p_name = $all['shipping_firstname'] . " " . $all['shipping_lastname'];
				}
				$zakazniky->p_name = $p_name;

				$zakazniky->p_mesto = $all['shipping_city'];
				$zakazniky->p_ulice = $all['shipping_address_1'];
				$zakazniky->p_psc = $all['shipping_postcode'];
				$zakazniky->p_countries_id = Countries::getId($all['shipping_country']);
				$p_country = Countries::FindOne($zakazniky->p_countries_id);
				$p_cname = $p_country->name;
				$zakazniky->datetime = date('Y-m-d H:i:s');

				$zakazniky->insert();
				
				$zakazniky_id = Yii::$app->db->getLastInsertID();
				$data['insert_id'] = $zakazniky_id;
				
					// Log
				$log = Log::addLog("Přidal zákazníka", Yii::$app->db->getLastInsertID());

				// Create XML
				$xml = new DomDocument('1.0', 'utf-8');
				$s5Data = $xml->appendChild($xml->createElement('S5Data'));
					$firmaList = $s5Data->appendChild($xml->createElement('FirmaList'));
						$firma = $firmaList->appendChild($xml->createElement('Firma'));
							$firma->setAttribute('ID', $zakazniky->uuid);
							$group_id = $firma->appendChild($xml->createElement('Group'));  // Group
								$group_id->setAttribute('ID', $uuid_zs);

							/*
							$kod = $firma->appendChild($xml->createElement('Kod'));  // Kod (?)
								$kod->appendChild($xml->createTextNode(5));
							 */
							$ico = $firma->appendChild($xml->createElement('ICO'));    // ICO
								$ico->appendChild($xml->createTextNode($zakazniky->ico));
							/*	
							$dic = $firma->appendChild($xml->createElement('DIC'));    // DIC
								$dic->appendChild($xml->createTextNode($model->dic));
							*/	
							$nazev = $firma->appendChild($xml->createElement('Nazev'));    // DIC
								$nazev->appendChild($xml->createTextNode($zakazniky->o_name));

							$adresy = $firma->appendChild($xml->createElement('Adresy'));

								$obchodniAdresa = $adresy->appendChild($xml->createElement('ObchodniAdresa'));
									$onazev = $obchodniAdresa->appendChild($xml->createElement('Nazev'));
										$onazev->appendChild($xml->createTextNode($zakazniky->o_name));
									$oulice = $obchodniAdresa->appendChild($xml->createElement('Ulice'));
										$oulice->appendChild($xml->createTextNode($zakazniky->o_ulice));
									$omesto = $obchodniAdresa->appendChild($xml->createElement('Misto'));
										$omesto->appendChild($xml->createTextNode($zakazniky->o_mesto));	
									$ocountry = $obchodniAdresa->appendChild($xml->createElement('NazevStatu'));
										$ocountry->appendChild($xml->createTextNode($o_cname));	
									$opsc = $obchodniAdresa->appendChild($xml->createElement('KodPsc'));
										$opsc->appendChild($xml->createTextNode($zakazniky->o_psc));

								$odlisnaFA = $adresy->appendChild($xml->createElement('OdlisnaFakturacniAdresa'));
									$odlisnaFA->appendChild($xml->createTextNode('True'));


									$fakturacniAdresa = $adresy->appendChild($xml->createElement('FakturacniAdresa'));
										$fnazev = $fakturacniAdresa->appendChild($xml->createElement('Nazev'));
											$fnazev->appendChild($xml->createTextNode($zakazniky->f_name));
										$fulice = $fakturacniAdresa->appendChild($xml->createElement('Ulice'));
											$fulice->appendChild($xml->createTextNode($zakazniky->f_ulice));
										$fmesto = $fakturacniAdresa->appendChild($xml->createElement('Misto'));
											$fmesto->appendChild($xml->createTextNode($zakazniky->f_mesto));	
										$fcountry = $fakturacniAdresa->appendChild($xml->createElement('NazevStatu'));
											$fcountry->appendChild($xml->createTextNode($f_cname));	
										$fpsc = $fakturacniAdresa->appendChild($xml->createElement('KodPsc'));
											$fpsc->appendChild($xml->createTextNode($zakazniky->f_psc));


								$odlisnaPA = $adresy->appendChild($xml->createElement('OdlisnaAdresaProvozovny'));
									$odlisnaPA->appendChild($xml->createTextNode('True'));

									$provozovna = $adresy->appendChild($xml->createElement('Provozovna'));
										$pnazev = $provozovna->appendChild($xml->createElement('Nazev'));
											$pnazev->appendChild($xml->createTextNode($zakazniky->p_name));
										$pulice = $provozovna->appendChild($xml->createElement('Ulice'));
											$pulice->appendChild($xml->createTextNode($zakazniky->p_ulice));
										$pmesto = $provozovna->appendChild($xml->createElement('Misto'));
											$pmesto->appendChild($xml->createTextNode($zakazniky->p_mesto));	
										$pcountry = $provozovna->appendChild($xml->createElement('NazevStatu'));
											$pcountry->appendChild($xml->createTextNode($p_cname));	
										$ppsc = $provozovna->appendChild($xml->createElement('KodPsc'));
											$ppsc->appendChild($xml->createTextNode($zakazniky->p_psc));		
	

								$kontakty = $firma->appendChild($xml->createElement('Kontakty'));
									$email = $kontakty->appendChild($xml->createElement('Email'));
										$email->appendChild($xml->createTextNode($zakazniky->email));
										
									$telefon1 = $kontakty->appendChild($xml->createElement('Telefon1'));
										$cislo1 = $telefon1->appendChild($xml->createElement('Cislo'));
											$cislo1->appendChild($xml->createTextNode($zakazniky->phone));

									$emailSpojeni = $kontakty->appendChild($xml->createElement('EmailSpojeni'));
										$emailSpojeni->setAttribute('ID', $zakazniky->uuid_email);
									$telefonSpojeni1 = $kontakty->appendChild($xml->createElement('TelefonSpojeni1'));
										$telefonSpojeni1->setAttribute('ID', $zakazniky->uuid_phone);		


							$osoby = $firma->appendChild($xml->createElement('Osoby'));
								$hlavniOsoba = $osoby->appendChild($xml->createElement('HlavniOsoba'));
									$hlavniOsoba->setAttribute('ID', $zakazniky->uuid_kontaktni_osoba);
								$seznamOsob = $osoby->appendChild($xml->createElement('SeznamOsob'));
									$osoba = $seznamOsob->appendChild($xml->createElement('Osoba'));
										$osoba->setAttribute('ID', $zakazniky->uuid_kontaktni_osoba);
											$osnazev = $osoba->appendChild($xml->createElement('Nazev'));
												$osnazev->appendChild($xml->createTextNode($zakazniky->kontaktni_osoba));
											$cislo_osoby = $osoba->appendChild($xml->createElement('CisloOsoby'));
												$cislo_osoby->appendChild($xml->createTextNode("1"));

				$xml_list = $xml->saveXML();
				//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS

				$xml->formatOutput = true;
				$xml->save('xml/Firma-' . $zakazniky_id . '.xml');
				
			}
		}
		return json_encode($data);
	}
	
}