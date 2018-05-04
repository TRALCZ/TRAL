<?php

namespace app\controllers;

use Yii;
use DOMDocument;
use app\models\Seznam;
use app\models\SeznamSearch;
use app\models\SkladySeznam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\Moneys;
use app\models\CenikySeznam;
use app\models\Zakazniky;
use app\models\Log;

//use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\web\Response;
use yii\helpers\Json;

//use Imagine\Image\Point;
//use Imagine\Image\ImageInterface;
//use Imagine\Image\Box;

/**
 * SeznamController implements the CRUD actions for Seznam model.
 */
class SeznamController extends Controller
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
	 * Lists all Seznam models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new SeznamSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Seznam model.
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
	 * Creates a new Seznam model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Seznam();
		$moneys = new Moneys();
		$cenikySeznam = new CenikySeznam();
		$skladySeznam = new SkladySeznam();
		$log = new Log();
		$category = new Category();
		
		if ($model->load(Yii::$app->request->post()))
		{
			//$model->zakazniky_id = Yii::$app->request->post('zakazniky_id');
			
			$sklady_id = Yii::$app->request->post('sklady_id');
			$ceniky_id = Yii::$app->request->post('ceniky_id');
			$cena_bez_dph = Yii::$app->request->post('cena_bez_dph');
			
			$celkem_priplatek = Yii::$app->request->post('celkem-priplatek');
			
			$priplatek_options_id = array();
			for($i=0; $i<$celkem_priplatek; $i++)
			{
				if (Yii::$app->request->post('priplatek_options_id' . $i) <> null)
				{
					$priplatek_options_id[] = Yii::$app->request->post('priplatek_options_id' . $i);
				}
				else
				{
					$priplatek_options_id[] = '0';
				}
				
			}
			
			if(count($priplatek_options_id) > 0)
			{
				$model->priplatek_options_id = json_encode($priplatek_options_id);
			}

			// Check name
			$count = $model->getCountName($model->name);
			if ($count > 0)
			{
				Yii::$app->session->setFlash('danger', "Pozor! Už máte takove zboži!");
				return $this->redirect(['index']);
			}	
			
			if (strpos($model->name, 'Interiérové dveře') !== false)
			{
				$model->uuid = $moneys->createID();
				$model->category_id = $model->addModelToCategory($model->name);
			}
			
			if ($model->druh_id == 2) // Sluzba
			{
				$model->typ_id = 2;
				$model->norma_id = 0;
				$model->modely_id = 0;
				$model->odstin_id = 0;
				$model->rozmer_id = 0;
				$model->otevirani_id = 0;
				$model->typzamku_id = 0;
				$model->vypln_id = 0;
				$model->ventilace_id = 0;
				
				$model->category_id = 0; // sluzba

			}

			if ($model->save())
			{
				//print_r($model->getErrors());
				
				$seznam = Seznam::findOne($model->id);
				$seznam->kod = str_pad($model->id, 7, '0', STR_PAD_LEFT);
				$seznam->update();
				
				// CenikySeznam
				$data['ceniky_id'] = $ceniky_id;
				$data['cena'] = $cena_bez_dph;
				$data['typceny_id'] = 1;
				$data['seznam_id'] = $model->id;
				$sc = $cenikySeznam->insertCenikySeznam($data);
				
				// SkladySeznam
				$data['sklady_id'] = $sklady_id;
				$data['seznam_id'] = $model->id;
				$data['zasoba_pojistna'] = 0;
				$ss = $skladySeznam->insertSkladySeznam($data);
				
				// Log
				$log = $log->addLog("Přidal zboží", $model->id);
				
				if ($sc > 0 && $ss > 0)
				{
					// Create XML
					$xml = new DomDocument('1.0', 'utf-8');
					$s5Data = $xml->appendChild($xml->createElement('S5Data'));
						$artiklList = $s5Data->appendChild($xml->createElement('ArtiklList'));
							$artikl = $artiklList->appendChild($xml->createElement('Artikl'));
								$artikl->setAttribute('ID', $model->uuid);
									
									$category = $category->findOne($model->category_id);
									$group = $artikl->appendChild($xml->createElement('Group'));
										$group->setAttribute('ID', $category->uuid);
							
									$nazev = $artikl->appendChild($xml->createElement('Nazev'));
										$nazev->appendChild($xml->createTextNode($model->name));
									$popis = $artikl->appendChild($xml->createElement('Popis'));
										$popis->appendChild($xml->createTextNode($model->name));
									$kod = $artikl->appendChild($xml->createElement('Kod'));
										$kod->appendChild($xml->createTextNode($seznam->kod));
									$carovyKod = $artikl->appendChild($xml->createElement('CarovyKod'));
										$carovyKod->appendChild($xml->createTextNode($model->carovy_kod));
									$hmotnost = $artikl->appendChild($xml->createElement('VlastniHmotnost'));
										$hmotnost->appendChild($xml->createTextNode($model->hmotnost));
									
									$dlhuta = $artikl->appendChild($xml->createElement('DodaciLhuta'));
										$doba = $dlhuta->appendChild($xml->createElement('Doba'));
										$doba->appendChild($xml->createTextNode($model->dodaci_lhuta));
									
									$zakazniky = Zakazniky::findOne($model->zakazniky_id);
									$dodavatele = $artikl->appendChild($xml->createElement('Dodavatele'));
										$hlDodavatel = $dodavatele->appendChild($xml->createElement('HlavniDodavatel'));
											//$hlDodavatel->setAttribute('ID', $zakazniky->uuid);
										$seznamDodavatelu = $dodavatele->appendChild($xml->createElement('SeznamDodavatelu'));
											$artiklDodavatel = $seznamDodavatelu->appendChild($xml->createElement('ArtiklDodavatel'));
												//$artiklDodavatel->setAttribute('ID', $zakazniky->uuid);	
												$firmaID = $artiklDodavatel->appendChild($xml->createElement('Firma_ID'));
													$firmaID->appendChild($xml->createTextNode($zakazniky->uuid));
												$nazevFirmy = $artiklDodavatel->appendChild($xml->createElement('NazevFirmy'));
													$nazevFirmy->appendChild($xml->createTextNode($zakazniky->o_name));	
										
									
					$xml_list = $xml->saveXML();
					//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS

					$xml->formatOutput = true;
					$xml->save('xml/Seznam-' . $model->id . '.xml');
					
					return $this->redirect(['index']);
				}
				
			}
		} 
		else
		{
			return $this->render('create', [
					'model' => $model,
					//'model2' => $model2,
			]);
		}
	}

	public function actionCreateDvere()
	{
		$model = new Seznam();

		if ($model->load(Yii::$app->request->post()))
		{
			if ($model->save())
			{
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}
		else
		{
			return $this->render('create-dvere', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Seznam model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		return $this->redirect(['index']);
		/*
		$model = $this->findModel($id);
		
		
		
		
		if ($model->load(Yii::$app->request->post()))
		{
			//echo (Yii::$app->request->post('cena_bez_dph'));
			//exit();
			
			$cena_bez_dph = Yii::$app->request->post('cena_bez_dph');

			// Category
			//InteriГ©rovГ© dveЕ™e ALEJA 0/3 70 L dub LAK PZ CZ
			
			if (strpos($model->name, 'InteriГ©rovГ© dveЕ™e') !== false)
			{
				$popis = explode(" ", $model->name);
				$popis = array_map('strtolower', $popis);
				
				if ($popis[3])
				{
					if ($popis[3] != "lux") // 33
					{
						$name = $popis[2]; // aleja
					}
					else
					{
						$name = $popis[2] . ' ' . $popis[3]; // aleja lux
					}
				}
				
				$category = Category::find()->where([strtolower('name')=>$name])->one();
				$parent_id = $category['id']; // 4
				
				// Typ zamku
				if (in_array('bb', $popis))
				{
					$typzamku = 'bb';
				}
				else if (in_array('pz', $popis))
				{
					$typzamku = 'pz';
				}
				else if (in_array('wc', $popis))
				{
					$typzamku = 'wc';
				}
				else if (in_array('uz', $popis))
				{
					$typzamku = 'uz';
				}
				
				$category2 = Category::find()->where([strtolower('name')=>$typzamku, 'parent_id'=>$parent_id])->one();
				$category_id = $category2['id'];
				
			
				$model->category_id = $category_id;
				
				$model->kod = str_pad($model->id, 7, '0', STR_PAD_LEFT);
			}
			
			if ($model->save())
			{
				
				$category = Category::findOne($model->category_id);
				$category_uuid = $category->uuid;
				
				
				// CenikySeznam
				$data['ceniky_id'] = $model->ceniky_id;
				$data['name'] = $model->name;
				$data['cena'] = $cena_bez_dph;
				$data['typceny_id'] = 1;
				$data['seznam_id'] = $model->id;
				$sc = CenikySeznam::updateCenikySeznam($data);
				
				// SkladySeznam
				$data['sklady_id'] = $model->sklady_id;
				$data['name'] = $model->name;
				$data['cena'] = $cena_bez_dph;
				$data['typceny_id'] = 1;
				$data['seznam_id'] = $model->id;
				$ss = SkladySeznam::insertSkladySeznam($data);
				
				
				
				
				// Create XML
				$xml = new DomDocument('1.0', 'utf-8');
				$s5Data = $xml->appendChild($xml->createElement('S5Data'));
					$artiklList = $s5Data->appendChild($xml->createElement('ArtiklList'));
						$artikl = $artiklList->appendChild($xml->createElement('Artikl'));
						$artikl->setAttribute('ID', $model->uuid);
							$group = $artikl->appendChild($xml->createElement('Group'));
								$group->setAttribute('ID', $category_uuid);
							$nazev = $artikl->appendChild($xml->createElement('Nazev'));
								$nazev->appendChild($xml->createTextNode($model->name));
							$popis = $artikl->appendChild($xml->createElement('Popis'));
								$popis->appendChild($xml->createTextNode($model->name));
							$kod = $artikl->appendChild($xml->createElement('Kod'));
								$kod->appendChild($xml->createTextNode($model->kod));	

				$xml_list = $xml->saveXML();
				//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS

				$xml->formatOutput = true;
				$xml->save('xml/Seznam-' . $model->id . '.xml');

				return $this->redirect(['index']);
			}
		} 
		else
		{
			return $this->render('update', [
					'model' => $model
			]);
		}
		 * 
		 */
	}
	
	public function actionCopy($id)
	{
		$model = $this->findModel($id);
		
		$model2 = new Seznam();
		
		$seznam = new Seznam();
		$moneys = new Moneys();
		$cenikySeznam = new CenikySeznam();
		$skladySeznam = new SkladySeznam();
		$log = new Log();
		$category = new Category();
		$zakazniky = new Zakazniky();
		
		if ($model->load(Yii::$app->request->post()))
		{
			$post_array = Yii::$app->request->post();
			
			$celkem_priplatek = Yii::$app->request->post('celkem-priplatek');
			
			$priplatek_options_id = array();
			for($i=0; $i<$celkem_priplatek; $i++)
			{
				if (Yii::$app->request->post('priplatek_options_id' . $i) <> null)
				{
					$priplatek_options_id[] = Yii::$app->request->post('priplatek_options_id' . $i);
				}
				else
				{
					$priplatek_options_id[] = '0';
				}
				
			}
				
			$model2->priplatek_options_id = json_encode($priplatek_options_id);
				
			$model2->uuid = $moneys->createID();
			$model2->name = $post_array['Seznam']['name'];
			$model2->typ_id = $post_array['Seznam']['typ_id'];
			$model2->norma_id = $post_array['Seznam']['norma_id'];
			$model2->rada_id = $post_array['Seznam']['rada_id'];
			$model2->modely_id = $post_array['Seznam']['modely_id'];
			$model2->odstin_id = $post_array['Seznam']['odstin_id'];
			$model2->rozmer_id = $post_array['Seznam']['rozmer_id'];
			$model2->otevirani_id = $post_array['Seznam']['otevirani_id'];
			$model2->typzamku_id = $post_array['Seznam']['typzamku_id'];
			$model2->vypln_id = $post_array['Seznam']['vypln_id'];
			$model2->ventilace_id = $post_array['Seznam']['ventilace_id'];
			$model2->kod = '0000000';
			$model2->carovy_kod = $post_array['Seznam']['carovy_kod'];
			$model2->hmotnost = $post_array['Seznam']['hmotnost'];
			$model2->category_id = 1;
			$model2->druh_id = $post_array['Seznam']['druh_id'];
			//$model2->zakazniky_id = Yii::$app->request->post('zakazniky_id');
			$model2->zakazniky_id = $post_array['Seznam']['zakazniky_id'];
			$model2->dodaci_lhuta = $post_array['Seznam']['dodaci_lhuta'];
			$model2->is_delete = '0';

			$sklady_id = Yii::$app->request->post('sklady_id');
			$ceniky_id = Yii::$app->request->post('ceniky_id');
			$cena_bez_dph = Yii::$app->request->post('cena_bez_dph');
			
			// Check name
			
			$count = $seznam->getCountName($model2->name);
			if ($count > 0)
			{
				Yii::$app->session->setFlash('danger', "Pozor! Už máte takove zboži!");
				return $this->redirect(['index']);
			}	
			
			if (strpos($model2->name, 'Interiérové dveře') !== false)
			{
				$model2->category_id = $seznam->addModelToCategory($model2->name);
			}
			
			/*
			if ($model2->druh_id == 2) // Sluzba
			{
				$model2->typ_id = 2;
				$model2->norma_id = 0;
				$model2->modely_id = 0;
				$model2->odstin_id = 0;
				$model2->rozmer_id = 0;
				$model2->otevirani_id = 0;
				$model2->typzamku_id = 0;
				$model2->vypln_id = 0;
				$model2->ventilace_id = 0;
				
				$model2->category_id = 0; // sluzba
			}
			*/
			
			if ($model2->save())
			{
				$seznam = $seznam->findOne($model2->id);
				$seznam->kod = str_pad($model2->id, 7, '0', STR_PAD_LEFT);
				$seznam->update();
				
				// CenikySeznam
				$data['ceniky_id'] = $ceniky_id;
				$data['cena'] = $cena_bez_dph;
				$data['typceny_id'] = 1;
				$data['seznam_id'] = $model2->id;
				$sc = $cenikySeznam->insertCenikySeznam($data);
				
				// SkladySeznam
				$data['sklady_id'] = $sklady_id;
				$data['seznam_id'] = $model2->id;
				$data['zasoba_pojistna'] = 0;
				$ss = $skladySeznam->insertSkladySeznam($data);
				
				if ($sc > 0 && $ss > 0)
				{
					// Create XML
					$xml = new DomDocument('1.0', 'utf-8');
					$s5Data = $xml->appendChild($xml->createElement('S5Data'));
						$artiklList = $s5Data->appendChild($xml->createElement('ArtiklList'));
							$artikl = $artiklList->appendChild($xml->createElement('Artikl'));
								$artikl->setAttribute('ID', $model2->uuid);
									
									$category = $category->findOne($model2->category_id);
									$group = $artikl->appendChild($xml->createElement('Group'));
										$group->setAttribute('ID', $category->uuid);
							
									$nazev = $artikl->appendChild($xml->createElement('Nazev'));
										$nazev->appendChild($xml->createTextNode($model2->name));
									$popis = $artikl->appendChild($xml->createElement('Popis'));
										$popis->appendChild($xml->createTextNode($model2->name));
									$kod = $artikl->appendChild($xml->createElement('Kod'));
										$kod->appendChild($xml->createTextNode($seznam->kod));
									$carovyKod = $artikl->appendChild($xml->createElement('CarovyKod'));
										$carovyKod->appendChild($xml->createTextNode($model2->carovy_kod));
									$hmotnost = $artikl->appendChild($xml->createElement('VlastniHmotnost'));
										$hmotnost->appendChild($xml->createTextNode($model2->hmotnost));
									
									$dlhuta = $artikl->appendChild($xml->createElement('DodaciLhuta'));
										$doba = $dlhuta->appendChild($xml->createElement('Doba'));
										$doba->appendChild($xml->createTextNode($model2->dodaci_lhuta));
									
									$zakazniky = $zakazniky->findOne($model2->zakazniky_id);
									$dodavatele = $artikl->appendChild($xml->createElement('Dodavatele'));
										$hlDodavatel = $dodavatele->appendChild($xml->createElement('HlavniDodavatel'));
											//$hlDodavatel->setAttribute('ID', $zakazniky->uuid);
										$seznamDodavatelu = $dodavatele->appendChild($xml->createElement('SeznamDodavatelu'));
											$artiklDodavatel = $seznamDodavatelu->appendChild($xml->createElement('ArtiklDodavatel'));
												//$artiklDodavatel->setAttribute('ID', $zakazniky->uuid);	
												$firmaID = $artiklDodavatel->appendChild($xml->createElement('Firma_ID'));
													$firmaID->appendChild($xml->createTextNode($zakazniky->uuid));
												$nazevFirmy = $artiklDodavatel->appendChild($xml->createElement('NazevFirmy'));
													$nazevFirmy->appendChild($xml->createTextNode($zakazniky->o_name));	
										
									
					$xml_list = $xml->saveXML();
					//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS

					$xml->formatOutput = true;
					$xml->save('xml/Seznam-' . $model->id . '.xml');
					
					return $this->redirect(['index']);
				}
			}
			
		} 
		else
		{
			return $this->render('copy', [
					'model' => $model
			]);
		}
	}

	/**
	 * Deletes an existing Seznam model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		//$this->findModel($id)->delete();
		
		$seznam = Seznam::findOne($id);
		$seznam->is_delete = '1';
		$seznam->update();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Seznam model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Seznam the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Seznam::findOne($id)) !== null)
		{
			return $model;
		} else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	protected function findModel2($id)
	{
		if (($model = Category::findOne($id)) !== null)
		{
			return $model;
		} else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
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
	
	

}
