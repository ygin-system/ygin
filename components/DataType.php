<?php

class DataType {

  const INT = 1;
  const VARCHAR = 2;
  const EDITOR = 3;
  const TIMESTAMP = 4;
  const REFERENCE = 6;
  const OBJECT = 7;
  const FILE = 8;
  const BOOLEAN = 9;
  const ABSTRACTIVE = 10;
  const PRIMARY_KEY = 11;
  const ID_PARENT = 12;
  const SEQUENCE = 13;
  const TEXTAREA = 14;

  const FILES = 15;
  const HIDDEN = 17;

  const RADIO = 19;
  const EVAL_EXPRESSION = 20;

  public static $sqlType = array(
    DataType::INT         => 'INT(8)',
    DataType::VARCHAR     => 'VARCHAR(255)',
    DataType::EDITOR      => 'LONGTEXT',
    DataType::TIMESTAMP   => 'INT(10) UNSIGNED',
    DataType::REFERENCE   => 'INT(8)',
    DataType::OBJECT      => 'INT(8)',
    DataType::FILE        => 'INT(8)',
    DataType::BOOLEAN     => 'TINYINT(1)',
    DataType::PRIMARY_KEY => 'INT(8)',
    DataType::ID_PARENT   => 'INT(8)',
    DataType::SEQUENCE    => 'INT(8)',
    DataType::TEXTAREA    => 'LONGTEXT',
    DataType::HIDDEN      => 'VARCHAR(255)',

    DataType::FILES       => null,
    DataType::ABSTRACTIVE => null,
  );

  public static function getSqlType($type) {
    return (isset(self::$sqlType[$type]) ? self::$sqlType[$type] : null);
  }

}
