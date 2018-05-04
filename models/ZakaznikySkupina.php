<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zakazniky_skupina".
 *
 * @property integer $id
 * @property integer $radek
 * @property string $name
 * @property string $zkratka
 */
class ZakaznikySkupina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zakazniky_skupina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['radek', 'name', 'zkratka'], 'required'],
            [['radek'], 'integer'],
            [['name', 'uuid'], 'string', 'max' => 150],
            [['zkratka'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'uuid' => Yii::t('app', 'ID MoneyS'),
            'radek' => Yii::t('app', 'Řádek'),
            'name' => Yii::t('app', 'Skupina'),
            'zkratka' => Yii::t('app', 'Zkratka'),
        ];
    }

    /**
     * @inheritdoc
     * @return ZakaznikySkupinaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ZakaznikySkupinaQuery(get_called_class());
    }
	
	public static function ShowTree() 
	{ 
		$result = self::find()->orderBy('id')->all();

		echo("<ul>\n");
		foreach( $result as $row ) 
		{
			$id1 = $row["id"];
			echo("<li>\n");
			echo("<span class='skupiny_link' data-id='".$id1."'>".$row["name"]."</span>"."  \n");
		}
		echo("</ul>\n");
		
	}
	
	
	public function fullTree()
	{
		echo '
		<table style="width:100%">
		  <tr>
			<td valign="top" style="min-width: 250px; margin-right: 50px;">
			
			<div class="tree-data-container ZSkupiny" style="margin: 50px 20px 20px 0;">
			<ul class="jstree-container-ul jstree-children jstree-wholerow-ul jstree-no-dots" role="group">
			<li id="j1_0" class="jstree-node jstree-leaf" role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j1_0_anchor">
				<div class="jstree-wholerow" unselectable="on" role="presentation"> </div>
				<i class="jstree-icon jstree-ocl" role="presentation"></i>
				<a id="j1_28_anchor" class="jstree-anchor" href="#" tabindex="-1">
					<i class="jstree-icon jstree-themeicon" role="presentation"></i>
					<span class="skupiny_link" data-id="">VŠE</span>
				</a>
			</li>
			</ul>
			';

		ZakaznikySkupina::ShowTree();
			
		echo '
				</div>
			
			</td>

			<td valign="top">
		';
		
	}
}
