<?php

Yii::import('zii.widgets.CBreadcrumbs');

class BreadcrumbsWidget extends CBreadcrumbs {

  public $homeLink = false;

  public function run() {
    if (count($this->links) == 1) return; // не показываем ссылку на текущую строку

    echo CHtml::openTag($this->tagName, $this->htmlOptions)."\n";
    $links=array();

    if ($this->homeLink !== false) $this->links = array_merge($this->homeLink, $this->links);
    // последний элемент цепочки делаем без ссылки (текущий раздел)
    $count = count($this->links);
    $i = 0;
    foreach ($this->links as $label => $url) {
      $i++;
      $text = '';

      if ($i == $count) break;
      
      $text = CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url);
      //if ($i != ($count-1)) $text .= $this->separator;
      if ($this->tagName == 'ul') $text = '<li>' . $text . '</li>';
      
      /*
      if ($i != $count) {
        $text = CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url);
        $text .= $this->separator;
        if ($this->tagName == 'ul') $text = '<li>' . $text . '</li>';
      } else {
        $text = ($this->encodeLabel ? CHtml::encode($label) : $label);
        if ($this->tagName == 'ul') $text = '<li class="active">' . $text . '</li>';
      }*/
      
      $links[] = $text;
    }
    echo implode("\n", $links);
    echo CHtml::closeTag($this->tagName);
  }
}