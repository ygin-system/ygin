<?php
class NewsWidget extends DaWidget implements IParametersConfig {
  
  /**
   * Количество отображаемых новостей
   * @var int
   */
  public $maxNews = null;

  public static function getParametersConfig() {
    return array(
      'maxNews' => array(
        'type' => DataType::INT,
        'default' => 3,
        'label' => 'Количество отображаемых новостей',
        'required' => true,
      ),
    );
  }

  public function getNews() {
    return News::model()->last($this->maxNews)->findAll();
  }
  
  public function init() {
    if ($this->maxNews === null) {
      $this->maxNews = 3;
    }
    parent::init();
  }
  
  public function run() {
    $this->render('newsWidget');
  }
}