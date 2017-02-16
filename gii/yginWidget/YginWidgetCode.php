<?php
Yii::import('gii.CCodeModel');
class YginWidgetCode extends CCodeModel {
  public $widgetClass;
  public $widgetPath='application.widgets';
  public $baseClass='DaWidget';
  
  public function prepare() {
    $this->files=array();
    $templatePath=$this->templatePath;
    $widgetPath = Yii::getPathOfAlias($this->widgetPath);
    $widgetTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'widget.php';
    
    $this->files[]=new CCodeFile(
      $widgetPath.'/'.$this->widgetClass.'.php',
      $this->render($widgetTemplateFile)
    );
    
    $files=CFileHelper::findFiles($templatePath,array(
      'exclude'=>array(
        '.svn',
        '.gitignore'
      ),
    ));
    
    foreach($files as $file)
    {
      if($file!==$widgetTemplateFile)
      {
        if(CFileHelper::getExtension($file)==='php')
          $content=$this->render($file);
        elseif(basename($file)==='.yii')  // an empty directory
        {
          $file=dirname($file);
          $content=null;
        }
        else
          $content=file_get_contents($file);
        $this->files[]=new CCodeFile(
          $widgetPath.substr($file,strlen($templatePath)),
          $content
        );
      }
    }
  }
  
  public function rules()
  {
    return array_merge(parent::rules(), array(
      array('baseClass, widgetClass, widgetPath', 'filter', 'filter'=>'trim'),
      array('baseClass, widgetClass, widgetPath', 'required'),
      array('widgetPath', 'match', 'pattern'=>'/^(\w+[\w\.]*|\*?|\w+\.\*)$/', 'message'=>'{attribute} should only contain word characters, dots, and an optional ending asterisk.'),
      array('widgetClass, baseClass', 'match', 'pattern'=>'/^[a-zA-Z_]\w*$/', 'message'=>'{attribute} should only contain word characters.'),
      array('widgetPath', 'validateWidgetPath', 'skipOnError'=>true),
      array('baseClass, widgetClass', 'validateReservedWord', 'skipOnError'=>true),
      array('baseClass', 'validateBaseClass', 'skipOnError'=>true),
      array('baseClass', 'sticky'),
    ));
  }
  
  public function validateWidgetPath($attribute,$params)
  {
    if(Yii::getPathOfAlias($this->widgetPath)===false)
      $this->addError('widgetPath','Widget Path must be a valid path alias.');
  }
  
  public function validateBaseClass($attribute,$params)
  {
    $class=@Yii::import($this->baseClass,true);
    if(!is_string($class) || !$this->classExists($class))
      $this->addError('baseClass', "Class '{$this->baseClass}' does not exist or has syntax error.");
    elseif($class!=='DaWidget' && !is_subclass_of($class,'DaWidget'))
    $this->addError('baseClass', "'{$this->model}' must extend from DaWidget.");
  }
  
  public function getViewName() {
    return mb_strtolower(mb_substr($this->widgetClass, 0, 1)).mb_substr($this->widgetClass, 1);
  }
  
}