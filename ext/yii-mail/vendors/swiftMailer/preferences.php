<?php

/****************************************************************************/
/*                                                                          */
/* YOU MAY WISH TO MODIFY OR REMOVE THE FOLLOWING LINES WHICH SET DEFAULTS  */
/*                                                                          */
/****************************************************************************/

// Sets the default charset so that setCharset() is not needed elsewhere
Swift_Preferences::getInstance()->setCharset('utf-8');

// Without these lines the default caching mechanism is "array" but this uses
// a lot of memory.
// If possible, use a disk cache to enable attaching large attachments etc

// Пока выключаем, т.к. sys_get_temp_dir вызвает open_basedir restriction in effect Тимофеев 02.08.12
/*
if (function_exists('sys_get_temp_dir') && is_writable(sys_get_temp_dir()))
{
  Swift_Preferences::getInstance()
    -> setTempDir(sys_get_temp_dir())
    -> setCacheType('disk');
}
*/
