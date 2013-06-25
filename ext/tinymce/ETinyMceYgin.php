<?php

Yii::import('ygin.ext.tinymce.ETinyMce', true);

class ETinyMceYgin extends ETinyMce {

  public $firstRowOfButtons = array('justifyleft', 'justifyright', 'justifycenter', 'justifyfull', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', /*'fontsizeselect', 'fontselect', '|', */'formatselect', '|', 'forecolor', 'backcolor');
  public $secondRowOfButtons = array('undo', 'redo', '|', 'outdent', 'indent', '|', 'hr', 'link', 'unlink', '|', 'image', 'media', '|', 'sub', 'sup', 'bullist', 'numlist');
  public $thirdRowOfButtons = array('tablecontrols', '|', 'charmap', 'code');
  public $fourthRowOfButtons = array();
  private $_advancedStyles = array();

  public function setAddAdvancedStyles(array $advancedStyles) {
    $this->_advancedStyles = CMap::mergeArray($this->_advancedStyles, $advancedStyles);
  }

  public function getAssetsPath() {
    return Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
  }

  public function __construct($owner=null) {
    parent::__construct($owner);

    $this->setLanguage('ru');
    //$this->plugins = array('safari','pagebreak','style','layer','table','save','advhr','advimage','advlink','emotions','spellchecker','inlinepopups','insertdatetime','preview','media','searchreplace','print','contextmenu','paste','directionality','fullscreen','noneditable','visualchars','nonbreaking','xhtmlxtras','template');
    $this->plugins = array(
      //'advhr',          // +   расширенная HR диалог
      'advimage',         // + + вставка картинок
      'advlink',          // + + вставка ссылок
      //'autosave',       // +   автосохранение (подтверждает выход без сохранения)
      //'bbcode',         // +   Заменяет теги на бб код
      //'compat2x',       // ?
      //'contextmenu',    // +   контекстное меню
      //'directionality', // -   dir
      //'emotions',       // -   смайлы
      //'flash',          // -   вставка FLASH
      //'fullpage',       // -   свойства целой страницы
      //'fullscreen',     // +   ВЕСЬ ЭКРАН
      //'iespell',        // -   IE проверка праописания
      'inlinepopups',     // +   Позволяет добавлять диалоговые окна
      //'insertdatetime', // + + Вставка времени и даты
      //'layer',          // +   Операции со слоями
      'media',            // + + ВСтавка медиа
      //'nonbreaking',    // +   Кнопка вставки NBSP ?
      //'noneditable',    // -   Добавляет элемент, который нельзя редактировать. Работает в ИЕ и ФФ
      //'pagebreak'       // -   Позволяет добавить заранее заданные комментарии к тексту
      'paste',            // + + Вставка текста (обычный, ворд)
      'preview',          // + + Предварительный просмотр
      'print',            // + + Возможность печати
      //'safari'          //     Какая-то совместимость с браузером safari, при работе с ИЕ, ФФ, Оперой - плагин не подключается.
      //'save',           // + + Позволяет сохранить документ.
      //'searchreplace',    // + + Найти и заменить
      //'spellchecker',   // X   Проверка орфографии
      //'style',          // + + CSS Maker
      'table',            // + + Оформление таблиц
      //'template',       // -   Позволяет заводить шаблоны
      //'visualchars',    // + + Позволяет просматривать невидемые символы (напр. &nbsp;)
      //'xhtmlxtras',       // + + Дополнительные теги
    );
    $this->editorTemplate = 'full';
    $this->useCompression = false;
    $this->useSwitch = false;

    $validElement = "@[id|class|style|title|dir<ltr?rtl|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup],".
        "a[rel|rev|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur],".
        "-strike,".
        "#p,".
        "-ol[type|compact],".
        "-ul[type|compact],".
        "-li,".
        "-h1,-h2,-h3,-h4,-h5,-h6,".
        "-div,".
        "-span,".
        "img[longdesc|usemap|!src|alt=|title|hspace|vspace|width|height|align],".
        "-table[border=0|cellspacing=0|cellpadding=0|frame|rules|align|summary],".
        "-tr[rowspan],".
        "tbody,thead,tfoot,".
        "#td[colspan|rowspan|scope],".
        "#th[colspan|rowspan|scope],".
        "col[char|charoff|span],".
        "colgroup[char|charoff|span],".
        "object[classid|width|height|codebase|*],".
        "param[name|value|_value],".
        "embed[type|width|height|src|*],".
        "script[src|type],".
        "iframe[width|height|!src]".
        "-code,-pre,address,-sub,-sup,-blockquote,".
        "hr[size|noshade],".
        "caption,fieldset,noscript,legend,br,button,dfn,dd,dl,dt,cite,abbr,acronym,".
        "map[name],".
        "area[shape|coords|href|alt|target],".
        "form[action|accept|accept-charset|enctype|method],".
        "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],".
        "label[for],".
        "optgroup[label|disabled],".
        "option[disabled|label|selected|value],".
        "select[disabled|multiple|name|size],".
        "textarea[cols|rows|disabled|name|readonly]";

    $this->options = array(
      'accessibility_warnings' => false,
      'apply_source_formatting' => true,
      'verify_html' => false,
      'remove_script_host' => true,

      'force_p_newlines' => true,

      'paste_auto_cleanup_on_paste' => true,
      'paste_convert_middot_lists' => true,
      'paste_retain_style_properties' => 'border, border-right, border-top, border-left, border-bottom',
      'paste_strip_class_attributes' => 'all',
      'paste_remove_spans' => false,
      'paste_remove_styles_if_webkit' => false,
      'paste_remove_styles' => false,
      'forced_root_block' => false,

      'valid_elements' => $validElement,
    );
    $this->setContentCSS('/themes/business/css/content.css'); // TODO
  }

  public function init() {
    $cs = Yii::app()->clientScript;
    $editorJs = 'tiny_mce.js';
    if ($this->useCompression) {
      $editorJs = 'tiny_mce_gzip.js';
    }
    $cs->excludeJsFiles[] = $editorJs;
    parent::init();
  }

  /**
   * @param array $newPlugins
   */
  public function setAddPlugin(array $newPlugins) {
    $this->plugins = CMap::mergeArray($this->plugins, $newPlugins);
  }

  public function setAddOption(array $newOption) {
    $this->options = CMap::mergeArray($this->options, $newOption);
  }

  /**
   * A full editor
   *
   * @link http://tinymce.moxiecode.com/examples/full.php
   *
   * @param string $url the base URL for tinymce in assets
   * @return array
   */
  protected function makeFullEditor($url='') {
    $options = array();

    /*if (!empty($this->fontFamilies)) {
      $options['theme_advanced_fonts'] = implode(',', $this->fontFamilies);
    }
    if (!empty($this->fontSizes)) {
      $options['theme_advanced_font_sizes'] = implode(',', $this->fontSizes);
    }*/

    if (count($this->_advancedStyles) > 0) {
      $styles = '';
      foreach($this->_advancedStyles AS $caption => $style)
        $styles .= $caption.'='.$style.';';
      $options['theme_advanced_styles'] = $styles;

      $this->firstRowOfButtons[] = '|';
      $this->firstRowOfButtons[] = 'styleselect';
    }

    $options['dialog_type'] = 'modal';
    $options['theme'] = 'advanced';

    if (count($this->firstRowOfButtons) > 0)
      $options['theme_advanced_buttons1'] = implode(',', $this->firstRowOfButtons);
    if (count($this->secondRowOfButtons) > 0)
      $options['theme_advanced_buttons2'] = implode(',', $this->secondRowOfButtons);
    if (count($this->thirdRowOfButtons) > 0)
      $options['theme_advanced_buttons3'] = implode(',', $this->thirdRowOfButtons);
    if (count($this->fourthRowOfButtons) > 0)
      $options['theme_advanced_buttons4'] = implode(',', $this->fourthRowOfButtons);

    $options['theme_advanced_toolbar_location'] = 'top';
    $options['theme_advanced_toolbar_align'] = 'left';
    $options['theme_advanced_statusbar_location'] = 'bottom';
    $options['theme_advanced_resizing'] = true;
    $options['theme_advanced_resize_horizontal'] = false;

    //$options['theme_advanced_path_location'] = 'bottom';


    return $options;
  }

}