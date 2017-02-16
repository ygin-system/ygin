<?php

/**
 * This is the model class for table "da_domain".
 *
 * The followings are the available columns in table 'da_domain':
 * @property integer $id_domain
 * @property string $domain_path
 * @property string $name
 * @property integer $id_default_page
 * @property string $description
 * @property string $path2data_http
 * @property string $settings
 * @property string $keywords
 * @property integer $image_src
 * @property integer $active
 */
class Domain extends DaActiveRecord {

  const ID_OBJECT = 31;
  protected $idObject = self::ID_OBJECT;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Domain the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'da_domain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, id_default_page', 'required'),
			array('id_default_page, image_src, active', 'numerical', 'integerOnly'=>true),
			array('domain_path, name, description, path2data_http, keywords', 'length', 'max'=>255),
			array('settings', 'safe'),
		);
	}

  public function getDomainName() {
    return str_replace('http://', '', $this->name);
  }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(

		);
	}

/*  public function addSystemModule($idSystemModule) {
    // пока так
    $this->removeSystemModule($idSystemModule);
    Yii::app()->db->createCommand()->insert('da_domain_module', array('id_module'=>$idSystemModule, 'id_domain'=>$this->id_domain));
  }
  public function removeSystemModule($idSystemModule) {
    Yii::app()->db->createCommand()->delete('da_domain_module', 'id_module=:id_module AND id_domain=:id_domain', array(':id_module'=>$idSystemModule, ':id_domain'=>$this->id_domain));
  }*/

  /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_domain' => 'Id Domain',
			'domain_path' => 'Domain Path',
			'name' => 'Name',
			'id_default_page' => 'Id Default Page',
			'description' => 'Description',
			'path2data_http' => 'Path2data Http',
			'settings' => 'Settings',
			'keywords' => 'Keywords',
			'image_src' => 'Image Src',
			'active' => 'Active',
		);
	}

  protected function beforeSave() {
    return parent::beforeSave();
    /*if ($this->id_default_page == null) {
      //Создать страницу по умолчанию для домена
      $i = new Menu();
      $i->setName("Главная страница");
      //$i->setIdDomainInstance($instance->getIdInstance()); // TODO
      $i->save();

      $id = $i->getIdInstance();
      if (!is_null($id)) $instance->addValue("idDefaultPage", $id);
    }*/
  }

  protected function beforeDelete() {
    throw new Exception("Удаление домена возможно только прямыми запросами с предварительным удалением всех зависимых данных.");
  }

  public function getBackendEventHandler() {
    return array(
      'class' => 'backend.backend.domain.DomainEventHandler'
    );
  }

}