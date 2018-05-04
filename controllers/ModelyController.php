<?php

namespace app\controllers;

use Yii;
use app\models\Modely;
use app\models\ModelySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * ModelyController implements the CRUD actions for Modely model.
 */
class ModelyController extends Controller
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
     * Lists all Modely models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModelySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Modely model.
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
     * Creates a new Modely model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Modely();

        if ($model->load(Yii::$app->request->post()))
		{
			$model->c_hladina = json_encode(Yii::$app->request->post('c-hladina'));
			
			$file = UploadedFile::getInstance($model, 'file');
			if ($file && $file->tempName)
			{
				$model->file = $file;
				if ($model->validate(['file']))
				{
					$dir = Yii::getAlias('images/models/');
					$fileName = $model->file->baseName . '.' . $model->file->extension;
					$model->file->saveAs($dir . $fileName);
					$model->file = $fileName;
					$model->image = '/' . $dir . 'thumbs/' . $fileName;

					// yii2-imagine
					$dir_resize = Yii::getAlias('@app') . '/web/' . $dir;

					$img = Image::getImagine()->open($dir_resize . $fileName);
					$size = $img->getSize();
					/*
					$ratio = $size->getWidth() / $size->getHeight();
					$width = 800;
					$height = round($width / $ratio);
					*
					 * 
					 */
					
					$ratio = $size->getHeight() / $size->getWidth();
					$height = 800;
					$width = round($height / $ratio);
					
					$box = new Box($width, $height);
					Yii::$app->controller->createDirectory(Yii::getAlias('images/models/thumbs'));
					$img->resize($box)->save(Yii::getAlias($dir_resize . 'thumbs/' . $fileName), ['quality' => 90]);
				}
			}

			if ($model->save())
			{
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing Modely model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
		{
           $model->c_hladina = json_encode(Yii::$app->request->post('c-hladina'));
			
			$current_image = $model->image;
			$current_file = $model->file;
		   
			//Если отмечен чекбокс «удалить файл»
			if ($model->del_img)
			{
				if (file_exists(Yii::getAlias('@webroot' . $current_image)))
				{
					//удаляем файл
					unlink(Yii::getAlias('@webroot' . $current_image));
					unlink(Yii::getAlias('@webroot' . '/images/models/' . $current_file));

					$model->image = null;
					$model->file = null;
					//$model->file = '';
					$model->del_img = 0;
				}
			}

			
			$file = UploadedFile::getInstance($model, 'file');
			if ($file && $file->tempName)
			{
				$model->file = $file;
					
				if ($model->validate(['file']))
				{
					$dir = Yii::getAlias('images/models/');
					$fileName = $model->file->baseName . '.' . $model->file->extension;
					$model->file->saveAs($dir . $fileName);
					$model->file = $fileName;
					$model->image = '/' . $dir . 'thumbs/' . $fileName;

					// yii2-imagine
					$dir_resize = Yii::getAlias('@app') . '/web/' . $dir;

					$img = Image::getImagine()->open($dir_resize . $fileName);
					$size = $img->getSize();
					
					/*
					$ratio = $size->getWidth() / $size->getHeight();
					$width = 800;
					$height = round($width / $ratio);
					*
					 * 
					 */
					$ratio = $size->getHeight() / $size->getWidth();
					$height = 800;
					$width = round($height / $ratio);
					
					
					$box = new Box($width, $height);
					Yii::$app->controller->createDirectory(Yii::getAlias('images/models/thumbs'));

					$img->resize($box)->save(Yii::getAlias($dir_resize . 'thumbs/' . $fileName), ['quality' => 90]);
				}
			}



			if ($model->save())
			{
				//return $this->redirect(['view', 'id' => $model->id]);
				return $this->redirect(['index']);
			}
        }
		else
		{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Modely model.
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
     * Finds the Modely model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Modely the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Modely::findOne($id)) !== null) {
            return $model;
        } else {
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
