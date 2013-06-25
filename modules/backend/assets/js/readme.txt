Назначение скриптов:

functions.js - файл с частоиспользуемыми функциями. Используется на очень многих сайтах в пользовательской части.

jquery.js - он и есть, нужен для всего

jquery-ui.custom.min.js - jquery UI, нужен для функций интерфейса (календарь, сортировка...), 
Используются в шаблонах модулей. /engine/admin/abstract_parameter/module_process.php 
Используется для сортировки в админке. /engine/admin/instance_admin_drawex.php
содержит:
  ui.core
  ui.widget.js
  ui.mouse.js
  ui.position.js
  ui.sortable.js
  ui.autocomplete
  ui.button
  ui.dialog
  ui.slider.js
  ui.datepicker
  ui.progressbar
  ui.draggable
Генерация файла осуществляется здесь: ui.jquery.com

jquery.ui.datepicker-ru.js  - русификатор для календаря (поля с датой)

json2-min.js - кодирование данных в json Используется всегда при применении jquery-ajax.