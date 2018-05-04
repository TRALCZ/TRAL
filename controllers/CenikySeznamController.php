<?php

namespace app\controllers;

use Yii;
use DOMDocument;
use app\models\CenikySeznam;
use app\models\CenikySeznamSearch;
use app\models\Moneys;
use app\models\Ceniky;
use app\models\Seznam;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CenikySeznamController implements the CRUD actions for CenikySeznam model.
 */
class CenikySeznamController extends Controller
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
     * Lists all CenikySeznam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CenikySeznamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CenikySeznam model.
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
     * Creates a new CenikySeznam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CenikySeznam();

        if ($model->load(Yii::$app->request->post()))
		{
            $model->uuid = Moneys::createID();
			
			if($model->save())
			{
				// Create XML
				$xml = new DomDocument('1.0', 'utf-8');
					$s5Data = $xml->appendChild($xml->createElement('S5Data'));
						$polozkaCenikuList = $s5Data->appendChild($xml->createElement('PolozkaCenikuList'));
							$polozkaCeniku = $polozkaCenikuList->appendChild($xml->createElement('PolozkaCeniku'));
								$polozkaCeniku->setAttribute('ID', $model->uuid);
									
									$cena = $polozkaCeniku->appendChild($xml->createElement('Cena'));
										$cena->appendChild($xml->createTextNode($model->cena));

									$ceniky = Ceniky::findOne($model->ceniky_id);
									
									$cenikID = $polozkaCeniku->appendChild($xml->createElement('Cenik_ID'));
										$cenikID->appendChild($xml->createTextNode($ceniky->uuid));	
									

									$seznam = Seznam::findOne($model->seznam_id);
									
									$artiklID = $polozkaCeniku->appendChild($xml->createElement('Artikl_ID'));
										$artiklID->appendChild($xml->createTextNode($seznam->uuid));
									
									$nazev = $polozkaCeniku->appendChild($xml->createElement('Nazev'));
										$nazev->appendChild($xml->createTextNode($seznam->name));
										
									$kod = $polozkaCeniku->appendChild($xml->createElement('Kod'));
										$kod->appendChild($xml->createTextNode($seznam->kod));


					$xml_list = $xml->saveXML();
					//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS
					
					$xml->formatOutput = true;
					$xml->save('xml/PolozkaCeniku-' . $model->id . '.xml');
				
				return $this->redirect(['index']);
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CenikySeznam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
		{
            if($model->save())
			{
				// Create XML
				$xml = new DomDocument('1.0', 'utf-8');
					$s5Data = $xml->appendChild($xml->createElement('S5Data'));
						$polozkaCenikuList = $s5Data->appendChild($xml->createElement('PolozkaCenikuList'));
							$polozkaCeniku = $polozkaCenikuList->appendChild($xml->createElement('PolozkaCeniku'));
								$polozkaCeniku->setAttribute('ID', $model->uuid);
									
									$cena = $polozkaCeniku->appendChild($xml->createElement('Cena'));
										$cena->appendChild($xml->createTextNode($model->cena));

									$ceniky = Ceniky::findOne($model->ceniky_id);
									
									$cenikID = $polozkaCeniku->appendChild($xml->createElement('Cenik_ID'));
										$cenikID->appendChild($xml->createTextNode($ceniky->uuid));	
									

									$seznam = Seznam::findOne($model->seznam_id);
									
									$artiklID = $polozkaCeniku->appendChild($xml->createElement('Artikl_ID'));
										$artiklID->appendChild($xml->createTextNode($seznam->uuid));
									
									$nazev = $polozkaCeniku->appendChild($xml->createElement('Nazev'));
										$nazev->appendChild($xml->createTextNode($seznam->name));
										
									$kod = $polozkaCeniku->appendChild($xml->createElement('Kod'));
										$kod->appendChild($xml->createTextNode($seznam->kod));


					$xml_list = $xml->saveXML();
					//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS
					
					$xml->formatOutput = true;
					$xml->save('xml/PolozkaCeniku-' . $model->id . '.xml');
				
				return $this->redirect(['index']);
			}
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CenikySeznam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
		
		$seznam = CenikySeznam::findOne($id);
		$seznam->is_delete = '1';
		$seznam->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CenikySeznam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CenikySeznam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CenikySeznam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
