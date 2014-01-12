<?php
class LinkPagerWidget extends CLinkPager {
  /**
   * Css-класс дива пейджера
   * @var unknown_type
   */
  public $pagerCssClass = 'pagination pagination-sm';
  
  
  /**
   * Шаблон метки активной кнопки
   * @property string
   */
  public $activeLabelTemplate = '<b><i>{label}</i></b>';
  public $ajaxProcessTemplate = '<div class="b-ajax-process"></div>'; // Блок с изображением процесса на аяксе
  /**
   * Шаблон метки неактивной кнопки 
   * @propery string
   */
  public $labelTemplate = '<i>{label}</i>';
  
  public $firstPageLabel = '<i class="glyphicon glyphicon-chevron-left"></i>';
  public $lastPageLabel = '<i class="glyphicon glyphicon-chevron-right"></i>';
  public $prevPageLabel = false;
  public $nextPageLabel = false;
  
  public function init() {
    if ($this->cssFile === null) {
      $this->cssFile = CHtml::asset(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'pager.css');
    }

    $this->header .= "";//CHtml::openTag('div', array('class' => $this->pagerCssClass));
    $this->footer = $this->ajaxProcessTemplate/*.CHtml::closeTag('div')*/.$this->footer;
    $this->htmlOptions['class']='yiiPager '.$this->pagerCssClass;

    parent::init();
  }
  
  protected function createPageButtons()
  {
    if(($pageCount=$this->getPageCount())<=1)
      return array();

    list($beginPage,$endPage)=$this->getPageRange();
    $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
    $buttons=array();

    // first page
    if ($this->firstPageLabel !== false) {
      $buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);
    }

    // prev page
    if($this->prevPageLabel !== false) {
      if (($page=$currentPage-1)<0) 
        $page=0;
      $buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);
    }

    // internal pages
    for($i=$beginPage;$i<=$endPage;++$i)
      $buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

    // next page
    if($this->nextPageLabel !== false) {
      if (($page=$currentPage+1)>=$pageCount-1)
        $page=$pageCount-1;
      $buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
    }

    // last page
    if ($this->lastPageLabel !== false) {
      $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);
    }

    /*$buttons = array();
    $buttons[] = '<li class="disabled"><a>«</a></li>
                <li class="active"><a>1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">»</a></li>';*/
    return $buttons;
  }
  
  protected function createPageButton($label, $page, $class, $hidden, $selected) {
    $class = '';
    if ($hidden || $selected) {
      $class = ' class="'.($hidden ? "disabled" : "active").'"';
    }
    return '<li'.$class.'>'.CHtml::link($label, $this->createPageUrl($page)).'</li>';
    
    //if ($selected) {
    //  return '<li class="'.$class.'">'.strtr($this->activeLabelTemplate, array('{label}' => $label)).'</li>';
    //}
    //return '<li class="'.$class.'">'.CHtml::link(strtr($this->labelTemplate, array('{label}' => $label)),$this->createPageUrl($page)).'</li>';
  }
  
}