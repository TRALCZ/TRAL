<?php

namespace app\controllers;

use Yii;
use DOMDocument;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\SkladySeznam;
use app\models\SkladySeznamSearch;
use app\models\Moneys;
use app\models\Sklady;
use app\models\Seznam;

/**
 * SkladySeznamController implements the CRUD actions for SkladySeznam model.
 */
class SkladySeznamController extends Controller
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
     * Lists all SkladySeznam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkladySeznamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SkladySeznam model.
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
     * Creates a new SkladySeznam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SkladySeznam();

        if ($model->load(Yii::$app->request->post()))
		{
            $model->uuid = Moneys::createID();
			
			if($model->save())
			{
				// Create XML

				$xml = new DomDocument('1.0', 'utf-8');
					$s5Data = $xml->appendChild($xml->createElement('S5Data'));
						$zasobaList = $s5Data->appendChild($xml->createElement('ZasobaList'));
							$zasoba = $zasobaList->appendChild($xml->createElement('Zasoba'));
								$zasoba->setAttribute('ID', $model->uuid);
									
									$seznam = Seznam::findOne($model->seznam_id);
									
									$artiklID = $zasoba->appendChild($xml->createElement('Artikl_ID'));
										$artiklID->appendChild($xml->createTextNode($seznam->uuid));
									
									$nazev = $zasoba->appendChild($xml->createElement('Nazev'));
										$nazev->appendChild($xml->createTextNode($seznam->name));
										
									$kod = $zasoba->appendChild($xml->createElement('Kod'));
										$kod->appendChild($xml->createTextNode($seznam->kod));

									$zasobaPojistna = $zasoba->appendChild($xml->createElement('ZasobaPojistna'));
										$zasobaPojistna->appendChild($xml->createTextNode($model->zasoba_pojistna));
										
									
									$sklady = Sklady::findOne($model->sklady_id);

									$skladId = $zasoba->appendChild($xml->createElement('Sklad_ID'));
										$skladId->setAttribute('ID', $sklady->uuid);	

					$xml_list = $xml->saveXML();
					//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS
					
					$xml->formatOutput = true;
					$xml->save('xml/Zasoba-' . $model->id . '.xml');
					
				return $this->redirect(['index']);
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SkladySeznam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
			if($model->save())
			{
				// Create XML
				$xml = new DomDocument('1.0', 'utf-8');
					$s5Data = $xml->appendChild($xml->createElement('S5Data'));
						$zasobaList = $s5Data->appendChild($xml->createElement('ZasobaList'));
							$zasoba = $zasobaList->appendChild($xml->createElement('Zasoba'));
								$zasoba->setAttribute('ID', $model->uuid);
									
									$seznam = Seznam::findOne($model->seznam_id);
									
									$artiklID = $zasoba->appendChild($xml->createElement('Artikl_ID'));
										$artiklID->appendChild($xml->createTextNode($seznam->uuid));
									
									$nazev = $zasoba->appendChild($xml->createElement('Nazev'));
										$nazev->appendChild($xml->createTextNode($seznam->name));
										
									$kod = $zasoba->appendChild($xml->createElement('Kod'));
										$kod->appendChild($xml->createTextNode($seznam->kod));

									$zasobaPojistna = $zasoba->appendChild($xml->createElement('ZasobaPojistna'));
										$zasobaPojistna->appendChild($xml->createTextNode($model->zasoba_pojistna));
										
									
									$sklady = Sklady::findOne($model->sklady_id);

									$skladId = $zasoba->appendChild($xml->createElement('Sklad_ID'));
										$skladId->setAttribute('ID', $sklady->uuid);	

					$xml_list = $xml->saveXML();
					//$insert = Moneys::insertXML($xml_list); // Insert in MoneyS
					
					$xml->formatOutput = true;
					$xml->save('xml/Zasoba-' . $model->id . '.xml');
				
				return $this->redirect(['index']);
			}
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SkladySeznam model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
		
		$seznam = SkladySeznam::findOne($id);
		$seznam->is_delete = '1';
		$seznam->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SkladySeznam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SkladySeznam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SkladySeznam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
