<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

/**
 * Модель для таблицы "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
  if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
  }
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass; ?> {

  const ID_OBJECT = '<?php echo $this->getObjectId(); ?>';

  protected $idObject = self::ID_OBJECT;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return <?php echo $modelClass; ?> the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return '<?php echo $tableName; ?>';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
<?php foreach($rules as $rule): ?>
      <?php echo $rule.",\n"; ?>
<?php endforeach; ?>
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
<?php foreach($relations as $name=>$relation): ?>
      <?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
<?php foreach($labels as $name=>$label): ?>
      <?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
    );
  }

}