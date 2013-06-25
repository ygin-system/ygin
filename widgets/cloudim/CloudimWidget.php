<?php

class CloudimWidget extends DaWidget {
  
  public $htmlCode = null;
  
  public function run() {
    if ($this->htmlCode == null) {
      throw new ErrorException('Для виджета Cloudim не задан html-код');
    }
  	echo $this->htmlCode;
  }
  
}