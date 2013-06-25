<?php
class SearchParameter extends CComponent {
  /**
   * @var ObjectParameter
   */
  private $_parameter;
  /**
   * @var boolean
   */
  private $_visible = true;
  public function __construct(ObjectParameter $parameter) {
    $this->_parameter = $parameter;
  }
  public function setParameter(ObjectParameter $parameter) {
    $this->_parameter = $parameter;
  }
  public function getParameter() {
    return $this->_parameter;
  }
  public function setVisible($visible) {
    $this->_visible = $visible;
  }
  public function getVisible() {
    return $this->_visible;
  }
}