<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
//use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property integer $position
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }
	
	public function behaviors() {
        return [
			\yii\behaviors\TimestampBehavior::className(),
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
				//'depthAttribute' => 'depth',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'lvl',
            ],
        ];
    }
	
	public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
			[['position'], 'default', 'value' => 0],
            [['tree', 'lft', 'rgt', 'lvl', 'position'], 'integer'],
            [['zkratka', 'poznamka'], 'safe'],
            [['name', 'uuid'], 'string', 'max' => 150],
        ];
    }
	
	
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'uuid' => Yii::t('app', 'UUID'),
            'name' => Yii::t('app', 'Název'),
			'zkratka' => Yii::t('app', 'Zkratka'),
			'poznamka' => Yii::t('app', 'Poznámka'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'lvl' => Yii::t('app', 'Depth'),
			//'depth' => Yii::t('app', 'Depth'),
            'position' => Yii::t('app', 'Position'),
        ];
    }
	
	public function getParentId()
	{
		$parent = $this->parent;
		return $parent ? $parent->id : null;
	}
	
	public function getParent()
	{
		return $this->parents(1)->one();
	}
	
	public static function getTree($node_id = 0)
	{
		$children = [];
		
		if( !empty($node_id) )
		{
			$children = array_merge(
				self::findOne($node_id)->children()->column(),
				[$node_id]
			);	
		}
		
		$rows = self::find()->select('id, name, lvl')->where(['NOT IN', 'id', $children])->orderBy('tree, lft, position')->all();
		$return = [];
		foreach($rows as $row)
		{
			$return[$row->id] = str_repeat(' >> ', $row->lvl) . ' ' . $row->name;
		}
		return $return;			
	}

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
	
	public static function ShowTree($parentID, $lvl) 
	{ 
		global $link; 
		global $lvl; 
		$lvl++; 
		
		$result = self::find()->where("parent_id = " . $parentID)->orderBy('name')->all();
	
		echo("<ul>\n");
		foreach( $result as $row ) 
		{
			$id1 = $row["id"];
			echo("<li>\n");
			echo("<span class='category_link' data-id='".$id1."'>".$row["name"]."</span>"."  \n");
			self::ShowTree($id1, $lvl); 
			$lvl--;
		}
		echo("</ul>\n");
		
	}
	
	
	public function fullTree($parentID, $lvl)
	{
		echo '
		<table style="width:100%">
		  <tr>
			<td valign="top" style="min-width: 200px; margin-right: 50px;">
			
			<div class="tree-data-container CSkupiny" style="margin: 50px 20px 20px 0;">
			
			<ul class="jstree-container-ul jstree-children jstree-wholerow-ul jstree-no-dots" role="group">
				<li id="j1_0" class="jstree-node jstree-leaf" role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j1_0_anchor">
					<div class="jstree-wholerow" unselectable="on" role="presentation"> </div>
					<i class="jstree-icon jstree-ocl" role="presentation"></i>
					<a id="j1_28_anchor" class="jstree-anchor" href="#" tabindex="-1">
						<i class="jstree-icon jstree-themeicon" role="presentation"></i>
						<span class="category_link" data-id="">VŠE</span>
					</a>
				</li>
			</ul>
			
			<ul class="jstree-container-ul jstree-children jstree-wholerow-ul jstree-no-dots" role="group">
			<li id="j1_99" class="jstree-node jstree-leaf" role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j1_99_anchor">
				<div class="jstree-wholerow" unselectable="on" role="presentation"> </div>
				<i class="jstree-icon jstree-ocl" role="presentation"></i>
				<a id="j1_99_anchor" class="jstree-anchor" href="3" tabindex="-1">
					<i class="jstree-icon jstree-themeicon" role="presentation"></i>
					<span class="category_link" data-id="0">Služby</span>
				</a>
			</li>
			</ul>


			';

		Category::ShowTree($parentID, $lvl);
			
		echo '
				</div>
			
			</td>

			<td valign="top">
		';
		
	}

	
	public function getCategoryId($popis)
	{
		if (strpos($popis, 'Interiérové dveře') !== false)
		{
			$popis = explode(" ", $popis);
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
		}
		return $category_id;
	}
	
	
}
