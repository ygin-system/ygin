<?php
class DaLogFilter extends CLogFilter {
  
  public $ignoreCategories;
  
  public function filter(&$logs) {
    
    $ignoreCategories = array();
    
    if (is_string($this->ignoreCategories)) {
      $ignoreCategories = explode(', ', $this->ignoreCategories);
    } else {
      $ignoreCategories = $this->ignoreCategories;
    }
    
    if (!empty($logs)) {
      foreach($logs as $logKey => $log) {
        $category = $log[2];
        foreach ($ignoreCategories as $ignCat) {
          if ($category === $ignCat) {
            unset($logs[$logKey]);
          } else if (strpos($ignCat, '.*') !== false) {
            $ignCat = str_replace('.*', '', $ignCat) . '.'; 
            if (strpos($logCategory . '.', $ignCat) !== false) {
              unset($logs[$logKey]);
            }
          }
        }
      }
    }
    return parent::filter($logs);
  }
}