<?php
// TODO переписать под нормальную модель
  class StatView {
    public static function getCountViewByWhere($idObject, $type=null, $where=null) {
      $add = "";
      if ($type != null) {
        $add = " AND view_type=".$type;
      }
      if ($where != null) {
        $add .= " AND (".$where.")";
      }
  //    $sql = "SELECT id_instance, view_count FROM da_stat_view WHERE last_date_process=(SELECT MAX(last_date_process) FROM da_stat_view WHERE id_object = ".$idObject.$add.") id_object = ".$idObject.$add;
      $sql = "SELECT id_instance, view_count FROM da_stat_view WHERE id_object = ".$idObject.$add." ORDER BY last_date_process LIMIT 1";

      $data = Yii::app()->db->createCommand($sql)->queryAll();
      $result = array();
      foreach($data AS $row) {
        $result[$row['id_instance']] = $row['view_count'];
      }
      return $result;
    }
    
    public static function getCountViewByInstances($idObject, array $instances, $type = null) {
      $add = "";
      if ($type != null) {
        $add = " AND view_type=".$type;
      }      
      $collection = new DaActiveRecordCollection($instances);
      $array = $collection->getKeys();
      $sql = "SELECT id_instance, COUNT(view_count) AS c FROM da_stat_view WHERE id_object = ".$idObject." AND id_instance IN (".implode(", ", $array).')'.$add.' GROUP BY id_instance;';
      $data = Yii::app()->db->createCommand($sql)->queryAll();
      $result = array();
      foreach($data AS $row) {
        $result[$row['id_instance']] = $row['c'];
      }
      return $result;
    }
    
    public static function getCountView($idObject, $idInstance, $type=null) {
      $add = "";
      if ($type != null) {
        $add = " AND view_type=".$type;
      }
      $sql = "SELECT SUM(view_count) AS view_count FROM da_stat_view WHERE id_object = ".$idObject." AND id_instance = ".$idInstance.$add;
      $result = Yii::app()->db->createCommand($sql)->queryScalar();
      if ($result == null) $result = 0;
      return $result;
    }
    
    public static function newViewPacket($idObject, $arrayOfData, $type = 1, $maskDate = "", $saveHistory = true, $where="", $date = null) {
      /*
         $arrayOfData - структура вида: array(idInstance => array(dateView1, dateView1, ...), idInstance2 => array(dateView3, dateView4, ...))
         $date - дата, относительно которой идет сравнение по маске
       */
      
      $arrayOfResult = array(); // в результат вернём текущее кол-во просмотров (с учётом новых)
      $sql = "";
      if ($date == null) $date = time();

      $maskDateVal = null;
      $newArr = array();
      if (!$saveHistory && $maskDate != null) {  // отсекаем старые данные
        $maskDateVal = date($maskDate, $date);
        foreach ($arrayOfData AS $id => $arrayOfViewDate) {
          $c = count($arrayOfViewDate);
          for ($i = 0; $i < $c; $i++) {
            $d = $arrayOfViewDate[$i];
            if ($maskDateVal == date($maskDate, $d)) {
              if (array_key_exists($id, $newArr)) {
                $newArr[$id][] = $d;
              } else {
                $newArr[$id]= array($d);
              }
            }
          }
        }
      } else {
        $newArr = $arrayOfData;
      }

      foreach($newArr AS $idInstance => $arrayOfViewDate) {
        $result = 0;
        $c = count($arrayOfViewDate);
        if (!$saveHistory) {
          $sql2 = "SELECT view_count, last_date_process AS date FROM da_stat_view
                        WHERE id_object = $idObject AND id_instance = $idInstance
                        AND view_type = $type".($where != "" ? " AND ($where)" : "")." ORDER BY last_date_process DESC LIMIT 1";
          $row = Yii::app()->db->createCommand($sql2)->queryRow();
          if (is_array($row) && count($row) > 0) {
            $result = $row['view_count'];
            $dateQuery = $row['date'];
            // LOW_PRIORITY
            // Если дата истекла (зануляем статистику)
            if ($maskDate != "" && $maskDateVal != date($maskDate, $dateQuery)) {
              $sql = "UPDATE da_stat_view SET view_count = ".$c.", last_date_process = ".$date." 
                      WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." 
                      AND view_type = ".$type." AND last_date_process=".$dateQuery;
              $result = $c;
            } else {
              // Либо маска не задана (статистика за всё время без разреза дат), либо временной период продолжается
              $sql = "UPDATE da_stat_view SET view_count = (view_count + ".$c."), last_date_process = ".$date." 
                      WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." 
                      AND view_type = ".$type." AND last_date_process=".$dateQuery;
              $result += $c;
            }
          } else {
            //Вставили новый экземпляр
            $sql = "INSERT IGNORE INTO da_stat_view(id_object, id_instance, view_type, view_count, last_date_process)
                    VALUES(".$idObject.", ".$idInstance.", ".$type.", ".$c.", ".$date.")";
            $result = $c;
          }
        } else {
          // с сохранением истории
          $sql = "INSERT IGNORE INTO da_stat_view(id_object, id_instance, view_type, view_count, last_date_process)
                  VALUES ";
          for ($i = 0; $i < $c; $i++) {
            if ($i > 0) $sql .= ", ";
            $sql .= "(".$idObject.", ".$idInstance.", ".$type.", 1, ".$arrayOfViewDate[$i].")";
          }
        }
        $arrayOfResult[$idInstance] = $result;
        if ($sql != '') {
          Yii::app()->db->createCommand($sql)->execute();
        }
      }
      return $arrayOfResult;      
    }
    
    public static function newView($idObject, $idInstance, $type = 1, $maskDate = "", $saveHistory = true, $where = "", $date = null) {
      $result = StatView::newViewPacket($idObject, array($idInstance => array(time())), $type, $maskDate, $saveHistory, $where, $date);
      if (array_key_exists($idInstance, $result)) {
        return $result[$idInstance];
      }
      return 0;
/*
      // прошлая версия:
      $result = 0; // в результат вернём текущее кол-во просмотров (с учётом этого)
      $sql = "";
      if ($date == null) $date = time();
      if (!$saveHistory) {
        $q = new QuerySql();
        $q->setQuery("SELECT view_count, last_date_process AS date FROM da_stat_view 
                      WHERE id_object = $idObject AND id_instance = $idInstance 
                      AND view_type = $type".($where != "" ? " AND ($where)" : "")." ORDER BY last_date_process DESC LIMIT 1");
        
        $q->exec();
        if ($row = $q->next()) {
          $result = $row->view_count;
          $dateQuery = $row->date;
          // LOW_PRIORITY
          //Если дата истекла (зануляем статистику)
          if ($maskDate != "" && date($maskDate, $date) != date($maskDate, $dateQuery)) {
            $sql = "UPDATE da_stat_view SET view_count = 1, last_date_process = ".$date." 
                      WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." 
                      AND view_type = ".$type." AND last_date_process=".$dateQuery;
            $result = 1;
          } else {
            // Либо маска не задана (статистика за всё время без разреза дат), либо временной период продолжается
            $sql = "UPDATE da_stat_view SET view_count = (view_count + 1), last_date_process = ".$date." 
                    WHERE id_object = ".$idObject." AND id_instance = ".$idInstance." 
                    AND view_type = ".$type." AND last_date_process=".$dateQuery;
            $result ++;
          }
        }
        $q->free();
      }
      if ($result == 0) {
        //Вставили новый экземпляр
        $sql = "INSERT IGNORE INTO da_stat_view(id_object, id_instance, view_type, view_count, last_date_process)
                VALUES(".$idObject.", ".$idInstance.", ".$type.", 1, ".$date.")";
        $result = 1;
      }
      QuerySql::execsql($sql);
      return $result;*/
    }
  }
