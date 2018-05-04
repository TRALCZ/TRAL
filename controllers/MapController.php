<?php

namespace app\controllers;

use Yii;
use app\models\Map;
use app\models\MapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
//new \SimpleXMLElement(); 

/**
 * MapController implements the CRUD actions for Map model.
 */
class MapController extends Controller
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
     * Lists all Map models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Map model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$zakazka = $id;
		
		if(Yii::$app->request->post())
		{
			$zakazka = Yii::$app->request->post('zakazka');
			
			return $this->redirect(['view', 'id' => $zakazka]);
		}
		
		$mapy = Map::find()->where(['zakazka'=>$zakazka])->all();
		
		foreach($mapy as $map)
		{
			$maps[] = array('location' => [
                'city' => $map->city,
				'address' => $map->address,
				'postalCode' => $map->postalCode,
				'country' => $map->country,
            ],
            'htmlContent' => $map->htmlContent);
		}
		
		return $this->render('view',
			[
				'maps' => $maps
			]
		);
    }

    /**
     * Creates a new Map model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Map;

		if ($model->load(Yii::$app->request->post()))
		{
			
			$sumod = str_replace(' ', '', $model->sumod);

			$file = UploadedFile::getInstance($model, 'file');
			if ($file && $file->tempName)
			{
				$model->file = $file;
				if ($model->validate(['file']))
				{
					$dir = Yii::getAlias('xml/');
					$fileName = $model->file->baseName . '.' . $model->file->extension;
					$model->file->saveAs($dir . $fileName);
					$model->file = $fileName;
					$fileputh = $dir . $fileName;
					
					$s5data = simplexml_load_file($fileputh);
					
					$new_max = $model->zakazkaMAX() + 1;
					$map = new Map;
					foreach ($s5data->Factory_ZakazkaList as $fvl)
					{
						foreach($fvl->Factory_Zakazka as $fv)
						{
							
							if($fv->Objednavka->CelkovaCastka >= $sumod)
							{	
								if(strlen(trim($fv->PoznamkaKTerminum))> 1)
								{
									$poznamka = $fv->PoznamkaKTerminum;
								}
								else
								{
									$poznamka = " - ";
								}
								
								Yii::$app->db->createCommand()
									->insert('map', 
												[
													'sumod' => $sumod,
													'file' => $fileputh,
													'datetime_add' => date('Y-m-d H:i:s'),
													'zakazka' => $new_max, 
													'num' => $fv->CisloZakazky,
													'poznamka' => $fv->PoznamkaKTerminum,
													'sum' => $fv->Objednavka->CelkovaCastka,
													'icount' => $fv->Objednavka->PocetPolozek,
													'name' => $fv->Objednavka->AdresaKoncovehoPrijemce->Nazev,
													'city' => $fv->Objednavka->AdresaKoncovehoPrijemce->Misto,
													'address' => $fv->Objednavka->AdresaKoncovehoPrijemce->Ulice,
													'postalCode' => $fv->Objednavka->AdresaKoncovehoPrijemce->PSC,
													'country' => $fv->Objednavka->AdresaKoncovehoPrijemce->Stat,
													'phone' => $fv->Objednavka->AdresaKoncovehoPrijemce->Telefon,
													'email' => $fv->Objednavka->AdresaKoncovehoPrijemce->Email,
													'htmlContent' => "<h4>" . $fv->Objednavka->AdresaKoncovehoPrijemce->Nazev . 
																		"</h4>" . $fv->Objednavka->AdresaKoncovehoPrijemce->Ulice . "<br>" . 
																		$fv->Objednavka->AdresaKoncovehoPrijemce->PSC . ", " . $fv->Objednavka->AdresaKoncovehoPrijemce->Misto . "<br>" . 
																		$fv->Objednavka->AdresaKoncovehoPrijemce->Stat . 
																		"<br><br>Telefon: " . $fv->Objednavka->AdresaKoncovehoPrijemce->Telefon . 
																		"<br>Email: " . $fv->Objednavka->AdresaKoncovehoPrijemce->Email .
																		"<br><br>Číslo dokladu: " . $fv->CisloZakazky . 
																		"<br>Počet položek: " . $fv->Objednavka->PocetPolozek .
																		"<br>Celkem: " . $fv->Objednavka->CelkovaCastka . " Kč" .
																		"<br><br><strong>Poznámka k termínům:</strong> " . $poznamka . "<br>"
												]
										)
									->execute();
							}

						}
						
							
					}					
					
				}
				return $this->redirect(['view', 'id' => $model->zakazkaMAX()]);
			}

			if ($model->save())
			{
				return $this->redirect(['index']);
			}
		 } 
		else
		{
            return $this->render('create', [
                'model' => $model,
            ]);
        }	
    }

    /**
     * Updates an existing Map model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Map model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionTruncate()
    {
        Map::truncate();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Map model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Map the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Map::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
