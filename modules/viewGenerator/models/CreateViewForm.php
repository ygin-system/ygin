<?php
/**
 * Created by PhpStorm.
 * User: Cranky4
 * Date: 28.04.14
 * Time: 17:24
 */

class CreateViewForm extends BaseFormModel {
  public $filename;
  public $path = 'html/';
  public $caption = 'Заголовок страницы';

  const VIEWS_PATH = 'themes/business/views/';

  public function rules() {
    return array(
      array('filename, path', 'required'),
      array('filename, caption', 'length', 'max' => 30),
      array('path', 'length', 'max' => 100),
      array('filename', 'match',
        'pattern' => '/^[a-zA-Z0-9_\s]+$/',
        'message' => 'Допустимы только буквы, цифры и символ подчеркивания (_)',
      ),
      array('path', 'match',
        'pattern' => '/^[a-zA-Z0-9_\/\s]+$/',
        'message' => 'Допустимы только буквы, цифры, символы подчеркивания (_) и слеш (/)'
      ),
    );
  }

  /**
   * Declares attribute labels.
   */
  public function attributeLabels() {
    return array(
      'filename' => 'Имя файла',
      'path' => 'Размещение',
      'caption' => 'Заголовок страницы',
    );
  }
} 