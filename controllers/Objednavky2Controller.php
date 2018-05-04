<?php

namespace app\controllers;

use Yii;
use app\models\Nabidky;
use app\models\NabidkySearch;
use app\models\NabidkySeznam;
use app\models\Seznam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\db\Query;
use kartik\mpdf\Pdf;
/**
 * NabidkyController implements the CRUD actions for Nabidky model.
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
     * Lists all Nabidky models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NabidkySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];
		$dataProvider->query->andWhere(['objednavka_vystavena'=>'1']);

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
	
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
		{
		
			$nabidky_id = $model->id;
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
				
				if ($seznam_id > 0 && $nabidky_id > 0)
				{
					$nabidkySeznam = NabidkySeznam::addNabidkaSeznam($nabidky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
			}

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
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$nabidky_id = $id;
			$deleteNS = NabidkySeznam::deleteNabidkySeznam($nabidky_id);
			
			//print_r(Yii::$app->request->post());
			//exit();
			
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
				
				if ($seznam_id > 0 && $nabidky_id > 0)
				{
					$nabidkySeznam = NabidkySeznam::addNabidkaSeznam($nabidky_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
			}
			
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } else {
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
        $this->findModel($id)->delete();

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
	
	public function actionCreatePdf($id)
	{
		$objednavka = Nabidky::find()->where(['id' => $id])->one();
		//$status_id = $nabidka['status_id']; // status id
		
        $content = "
		Objednávka č. {$objednavka['id']}<br>
		

			";        
		
		$pdf = new Pdf([
			'mode' => Pdf::MODE_UTF8, 
			'format' => Pdf::FORMAT_A4, 
			'orientation' => Pdf::ORIENT_PORTRAIT, 
			'destination' => Pdf::DEST_DOWNLOAD, 
			'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			'cssInline' => '.kv-heading-1{font-size:18px}', 
			'options' => ['title' => 'Krajee Report Title'],
			'methods' => [ 
				'SetHeader'=>["ERKADO Objednávka č. {$id}"], 
				'SetFooter'=>['{PAGENO}'],
			],
			'filename' => "objednavka-{$id}.pdf",
			'content' => $content,  	
		]);
		
		
		return $pdf->render();
	}
	
}
