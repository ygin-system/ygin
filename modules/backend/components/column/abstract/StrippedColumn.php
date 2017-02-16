<?php


class StrippedColumn extends BaseColumn {
  public $maxLength = 200;
  public $type = 'raw';

  protected function renderDataCellContent($row, $data) {
    ob_start();
    parent::renderDataCellContent($row, $data);
    $str = strip_tags(ob_get_clean());
    if ($this->maxLength !== false) {
      $str = HText::crop($str, $this->maxLength);
    }
    echo nl2br($str);
  }

}