<?php

/**
 * This is the model class for table "da_visit_site".
 *
 * The followings are the available columns in table 'da_visit_site':
 * @property integer $id_instance
 * @property integer $id_object
 * @property integer $date
 * @property string $ip
 * @property integer $type_visit
 */
class VisitSite extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VisitSite the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'da_visit_site';
	}
	
	public static function check($idObject, $idInstance, $type, $ip, $expired, $countRepeats=1) {
    $validIp = true;
    if ($expired > 0) {
      $expired = time() - $expired;
      $digitalIp = $ip;
      if (is_string($ip)) {
        $digitalIp = ip2long($ip);
      }
      $criteria = new CDbCriteria();
      $criteria->addCondition('date>:date');
      $criteria->params = array(':date' => $expired);
      $criteria->addColumnCondition(array('type_visit' => $type, 'ip' => $ip, 'id_object' => $idObject));
      if ($idInstance != null) $criteria->addColumnCondition(array('id_instance' => $idInstance));
      $count = self::model()->count($criteria);
      if ($count < $countRepeats) $validIp = true; else $validIp = false;
    }
    return $validIp;
  }
  public static function saveCurrentVisit($idObject, $idInstance, $type=1) {
  	$vs = new VisitSite();
    $vs->id_object = $idObject;
    $vs->id_instance = $idInstance;
    $vs->type_visit = $type;
    $vs->ip = ip2long(HU::getUserIp());
    $vs->date = time();
    $vs->save();
  }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('ip, id_instance, id_object, date, type_visit', 'required'),
			array('ip, id_instance, id_object, date, type_visit', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array();
	}


}