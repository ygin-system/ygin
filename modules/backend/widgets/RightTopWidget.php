<?php

class RightTopWidget extends DaWidget {

  public $link = '/';
  public $caption = 'Сайт';
  
  public function run() {
    echo '<div class="btn-group pull-right">
            <a class="btn btn-inverse" target="_blank" href="'.$this->link.'"><i class="icon-home icon-white"></i> '.$this->caption.'</a>
          </div>'; 
  }

}
