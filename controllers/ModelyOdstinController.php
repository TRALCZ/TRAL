<?php

namespace app\controllers;

use Yii;
use app\models\ModelyOdstin;
use app\models\ModelyOdstinSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModelyOdstinController implements the CRUD actions for ModelyOdstin model.
 */
class ModelyOdstinController extends Controller
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
     * Lists all ModelyOdstin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModelyOdstinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ModelyOdstin model.
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
     * Creates a new ModelyOdstin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ModelyOdstin();

        if ($model->load(Yii::$app->request->post()))
		{
			//print_r(Yii::$app->request->post('arr_modely_id'));
			$arr_modely_id = Yii::$app->request->post('arr-modely_id'); // ["1","3"]
			
			//print_r($arr_modely_id);
			//exit();
			
			foreach ($arr_modely_id as $am)
			{
				$mo = new ModelyOdstin;
				$mo->modely_id = $am;
				$mo->odstin_id = $model->odstin_id;
				$mo->cena_odstin = $model->cena_odstin;
				$mo->insert();
				//$model->modely_id = $am;
				//$model->save();
			}
			
			
			
			//$model->save();
			
			//return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ModelyOdstin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ModelyOdstin model.
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
     * Finds the ModelyOdstin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ModelyOdstin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ModelyOdstin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
