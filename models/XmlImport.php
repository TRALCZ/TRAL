<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xml_import".
 *
 * @property int $id ID
 * @property string $file Soubor
 * @property int $kosik Košík
 * @property int $user_id Přidal
 * @property string $datetime Přidáno
 */
class XmlImport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xml_import';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'kosik'], 'integer'],
            [['datetime', 'result', 'errors'], 'safe'],
            //[['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml', 'mimeTypes' => 'text/xml, application/xml'],
			[['file'], 'file', 'extensions' => 'xml'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file' => Yii::t('app', 'Soubor'),
            'kosik' => Yii::t('app', 'Košík'),
            'user_id' => Yii::t('app', 'Přidal'),
			'result' => Yii::t('app', 'Result'),
			'errors' => Yii::t('app', 'Errors'),
            'datetime' => Yii::t('app', 'Přidáno'),
        ];
    }

    /**
     * @inheritdoc
     * @return XmlImportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new XmlImportQuery(get_called_class());
    }
	
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
}
