<?php

class DaActiveRecordCollection extends CMap {

  /**
   * Copies iterable data into the map.
   * Note, existing data in the map will be cleared first.
   * @param array $data the data to be copied from, must be an array of DaActiveRecord instance
   * @throws CException If data is neither an array nor an iterator.
   */
  public function copyFrom($data) {
    if(is_array($data)) {
      if ($this->getCount()>0) $this->clear();
      foreach($data as $value) {
        $this->add($value->getIdInstance(), $value);
      }
    }
    else if($data!==null)
      throw new CException(Yii::t('yii','Map data must be an array or an object implementing Traversable.'));
  }

}
