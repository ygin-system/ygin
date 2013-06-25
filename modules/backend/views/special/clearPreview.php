<?php

function isImage($ext) {
  $ext = strtolower($ext);
  return (in_array($ext, array(
    'jpg',
    'gif',
    'png',
    'bmp',
    'ico',
  )));
}
/**
 * Возвращает массив файлов изображений из папки
 */
function getImageFiles($dir='.', $exclude) {
  $files = array();
  $a = scandir($dir);
  foreach ($a as $k => $v) {
    if ($v == '.' || $v == '..') {
      continue;
    }
    if (is_dir($dir.'/'.$v)) {
      $files = array_merge($files, getImageFiles($dir.'/'.$v, $exclude));
    } else if (isImage(HFile::getExtension($v))) {
      $files[] = str_replace($exclude, '', $dir.'/'.$v);
    }
  }
  return $files;
}
/**
 * Возвращает одно из значений, в зависимости от числа $number
 * getWordFinishByNumber($count, 'файл', 'файла', 'файлов')
 */
function getWordFinishByNumber($number, $one, $two, $five) {
  return $number%10 == 1 ? $one : ($number%10 < 5 ? $two : $five);
}

$arrayOfNoRegisteredFiles = getImageFiles(Yii::getPathOfAlias('webroot').'/content/', Yii::getPathOfAlias('webroot').'/');

$action = HU::get('action');
$data = File::model()->findAll();
$idOfNotExistFiles = array();
$arrayOfNotExistFiles = array();
foreach($data as $v) {
  /**
   * @var $v File
   */
  $path = $v->getFilePath();
  // исключаем существующие файлы из массива всех файлов в папке content
  $indexOfRegisteredFile = array_search($path, $arrayOfNoRegisteredFiles);
  if ($indexOfRegisteredFile !== false) {
    unset($arrayOfNoRegisteredFiles[$indexOfRegisteredFile]);
  }
  // сохраняем все ид несуществующих файлов для запроса на удаление
  if (!file_exists($v->getFilePath(true))) {
    $idOfNotExistFiles[] = $v->id_file;
    $arrayOfNotExistFiles[] = $path;
  }
}

if (count($arrayOfNoRegisteredFiles) > 0 && $action == 'deleteNoRegister') {
  foreach ($arrayOfNoRegisteredFiles as $k => $v) {
    echo '<br>удаляем '.$v.'... ';
    echo (unlink(Yii::getPathOfAlias('webroot').'/'.$v) ? 'успешно!' : 'ошибка!');
    unset($arrayOfNoRegisteredFiles[$k]);
  }
}

echo '<h3>Проверка файлов на существование</h3>';
$count = count($arrayOfNoRegisteredFiles);
if ($count > 0) {
?>
<b style="color:red">В папке /content найден<?=getWordFinishByNumber($count, '', 'о', 'о')?> <?=$count?> файл<?=getWordFinishByNumber($count, '', 'а', 'ов')?>, не зарегистрированны<?=getWordFinishByNumber($count, 'й', 'х', 'х')?> в таблице da_files</b><br>
Список:<br />
<textarea name="" cols="" rows="10" style="width:95%" wrap="ON"><?=implode("\n", $arrayOfNoRegisteredFiles)?></textarea>
<br /><a href="?action=deleteNoRegister" onClick="if (!confirm('Уверены?')) return false">Удалить эти файлы?</a><br />
<?php
} else {
  echo '<b style="color:green">Незарегистрированных файлов в папке /content/ не обнаружено</b><br>';
}

$count = count($idOfNotExistFiles);
if ($count > 0) {
?>
<br>
<b style="color:red">В базе данных зарегистрирован<?=getWordFinishByNumber($count, '', 'о', 'о')?> <?=$count?> файл<?=getWordFinishByNumber($count, '', 'а', 'ов')?>, не найденны<?=getWordFinishByNumber($count, 'й', 'х', 'х')?> в папке /content/</b><br>
Вот их список:<br />
<textarea name="" cols="" rows="10" style="width:95%" wrap="ON"><?=implode("\n", $arrayOfNotExistFiles)?></textarea>
Запрос на их удаление:<br>
<textarea name="" cols="" rows="5" style="width:95%" wrap="ON" onclick="this.focus(); this.select()">DELETE FROM da_files WHERE id_file IN (<?php echo implode(', ', $idOfNotExistFiles)?>)</textarea><br>
<?php
} else {
  echo '<b style="color:green">Несуществующих файлов не обнаружено</b><br>';
}
