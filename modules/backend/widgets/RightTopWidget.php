<?php

class RightTopWidget extends DaWidget {

  public $link = '/';
  public $caption = 'Сайт';
  
  public function run() {
    echo '<li><a target="_blank" href="'.$this->link.'"><i class="glyphicon glyphicon-home icon-white"></i> '.$this->caption.'</a></li>'; 
  }

}
