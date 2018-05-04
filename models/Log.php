<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $controller_name
 * @property integer $user_id
 * @property string $message
 * @property string $datetime
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller_name', 'user_id'], 'required'],
            [['user_id','item_id'], 'integer'],
            [['message'], 'string'],
            [['ip', 'item_id', 'datetime'], 'safe'],
            [['controller_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'controller_name' => Yii::t('app', 'Controller'),
            'user_id' => Yii::t('app', 'Uživatel'),
			'item_id' => Yii::t('app', 'ID zboži/služby'),
            'message' => Yii::t('app', 'Zpráva'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }
	
	public static function addLog($message, $item_id, $controller_name = '', $action_name = '')
	{
		$addLogs = new Log;
		
		if ($controller_name == '')
		{
			$addLogs->controller_name = Yii::$app->controller->id; // nabidky
		}
		else
		{
			$addLogs->controller_name = $controller_name; // nabidky
		}
		
		if ($action_name == '')
		{
			$addLogs->action_name = Yii::$app->controller->action->id; // create
		}
		else
		{
			$addLogs->action_name = $action_name; // create
		}
		
		$addLogs->user_id = Yii::$app->user->id; // 1
		$addLogs->message = $message;
		$addLogs->ip = Yii::$app->getRequest()->getUserIP();
		$addLogs->item_id = $item_id;
		$addLogs->datetime = date('Y-m-d H:i:s');

		$addLogs->insert();
		
		return $addLogs; 
	}
	
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

}
