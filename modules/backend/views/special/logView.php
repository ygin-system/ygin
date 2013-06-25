<?php

echo 'Временно отключено';
return;

function array_assoc_sort_instance(&$array, $sort, $isDesc=false, $isNumeric=true,  $sort2=null) {
  if (!is_object(each($array))) {
    return false;
  }
  if ($isNumeric) {
    $symb =  !$isDesc ? '>' : '<';
    $cmp = create_function('$a, $b', ' return $a->getParam("'.$sort.'") == $b->getParam("'.$sort.'") ? $a->getParam("'.$sort2.'") '.$symb.' $b->getParam("'.$sort2.'") : $a->getParam("'.$sort.'") '.$symb.' $b->getParam("'.$sort.'"); ');
  } else {
    if ($sort2 != '') {
      if ($isDesc) {
        $cmp = create_function('$a, $b', ' return $b->getParam("'.$sort.'") == $a->getParam("'.$sort.'") ? strcmp($b->getParam("'.$sort2.'"), $a->getParam("'.$sort2.'")) : strcmp($b->getParam("'.$sort.'"), $a->getParam("'.$sort.'")); ');
      } else {
        $cmp = create_function('$a, $b', ' return $a->getParam("'.$sort.'") == $b->getParam("'.$sort.'") ? strcmp($a->getParam("'.$sort2.'"), $b->getParam("'.$sort2.'")) : strcmp($a->getParam("'.$sort.'"), $b->getParam("'.$sort.'")); ');
      }
    } else {
      if ($isDesc) {
        $cmp = create_function('$a, $b', ' return isset($a->getParam("'.$sort.'")) && isset($b->getParam("'.$sort.'")) ? strcmp($b->getParam("'.$sort.'"), $a->getParam("'.$sort.'")) : 1; ');
      } else {
        $cmp = create_function('$a, $b', ' return isset($a->getParam("'.$sort.'")) && isset($b->getParam("'.$sort.'")) ? strcmp($a->getParam("'.$sort.'"), $b->getParam("'.$sort.'")) : 1; ');
      }
   }
  }
  usort($array, $cmp);
}
function array_assoc_sort(&$array, $sort, $isDesc=false, $isNumeric=true, $sort2='') {
  if ($isNumeric) {
    $symb =  !$isDesc ? '>' : '<';
    $cmp = create_function('$a, $b', ' return $a["'.$sort.'"] '.$symb.' $b["'.$sort.'"]; ');
  } else {
    if ($sort2 != '') {
      if ($isDesc) {
        $cmp = create_function('$a, $b', ' return $b["'.$sort.'"] == $a["'.$sort.'"] ? strcmp($b["'.$sort2.'"], $a["'.$sort2.'"]) : strcmp($b["'.$sort.'"], $a["'.$sort.'"]); ');
      } else {
        $cmp = create_function('$a, $b', ' return $a["'.$sort.'"] == $b["'.$sort.'"] ? strcmp($a["'.$sort2.'"], $b["'.$sort2.'"]) : strcmp($a["'.$sort.'"], $b["'.$sort.'"]); ');
      }
    } else {
      if ($isDesc) {
        $cmp = create_function('$a, $b', ' return isset($a["'.$sort.'"]) && isset($b["'.$sort.'"]) ? strcmp($b["'.$sort.'"], $a["'.$sort.'"]) : 1; ');
      } else {
        $cmp = create_function('$a, $b', ' return isset($a["'.$sort.'"]) && isset($b["'.$sort.'"]) ? strcmp($a["'.$sort.'"], $b["'.$sort.'"]) : 1; ');
      }
    }
  }
  usort($array, $cmp);
}
function formatSize($bytes) {
  if ($bytes < pow(1024, 1)) {
    return "$bytes b";
  } else if ($bytes < pow(1024, 2)) {
    return round($bytes / pow(1024, 1), 2).' Kb';
  } else if ($bytes < pow(1024, 3)) {
    return round($bytes / pow(1024, 2), 2).' Mb';
  } else if ($bytes < pow(1024, 4)) {
    return round($bytes / pow(1024, 3), 2).' Gb';
  }
}

if (GET('log') != '') {

  $reverse = GET('reverse', '1');
  $withTime = GET('with_time', '1');

  $file = DA_ROOT.'log/'.GET('log');
  
  $max = 1024*1024*10;
  if (filesize($file) > $max) {
    $fd = fopen ($file, 'r');
    if (GET('reverse')) {
      fseek ($fd, filesize($file) - $max);
    }
    $file = explode("\n", fread($fd, $max));
    fclose ($fd);
  } else {
    $file = file($file);
  }

?>

Сортировка: 
<?php if ($reverse == '0') { ?>
ASC <a href="<?php echo str_replace('&reverse=0', '', $_SERVER['REQUEST_URI']) ?>">DESC</a>
<?php } else { ?>
<a href="<?php echo str_replace('&reverse=0', '', $_SERVER['REQUEST_URI']) ?>&reverse=0">ASC</a> DESC
<?php } ?>

&nbsp; | &nbsp;

Выводить строк: <a href="<?php echo preg_replace('~&count=\d+~', '', $_SERVER['REQUEST_URI']) ?>&count=1000">1000</a>
<a href="<?php echo preg_replace('~&count=\d+~', '', $_SERVER['REQUEST_URI']) ?>&count=2000">2000</a>
<a href="<?php echo preg_replace('~&count=\d+~', '', $_SERVER['REQUEST_URI']) ?>&count=5000">5000</a>

&nbsp; | &nbsp;

<?php if ($withTime == '1') { ?>
<a href="<?php echo str_replace('&with_time=0', '', $_SERVER['REQUEST_URI']) ?>&with_time=0">Без времени</a>
<?php } else { ?>
<a href="<?php echo str_replace('&with_time=0', '', $_SERVER['REQUEST_URI']) ?>">Со временем</a>
<?php } ?>

&nbsp; | &nbsp;

<?php
  global $urlPage;
  $urlPage->setDefaultUrl();
  $url = $urlPage->getUrl();
?>
<a href="<?php echo $url; ?>">Вернуться к списку логов</a>
<br />
<?php

  $dataOnPage = GET('count', 1000);
  $dataFrom   = GET('start', 0);
  $dataCount  = count($file);
  echo 'Всего: '.$dataCount;
  if ($dataCount > $dataOnPage) {
    $dataPages  = ceil($dataCount / $dataOnPage);
    for ($i = 0; $i < $dataPages; $i ++) {
      $start = $i * $dataOnPage;
      if ($i % 20 == 0) {
        echo '<br />';
      }
      if ($start == $dataFrom) {
        echo '<b>'.$start.'</b> ';
      } else {
        echo '<a href="'.preg_replace('~&start=\d+~', '', $_SERVER['REQUEST_URI']).'&start='.$start.'">'.$start.'</a> ';
      }
    }
  }
  echo "<br>";
  if ($reverse == '1') {
    $file = array_reverse($file);
  }
  $file = array_slice($file, $dataFrom, $dataOnPage);

  $previousDate = '';
  $stringPrev = '';
  foreach ($file as $i => $string) {
    $a = explode(' ', $string);
    if (count($a) < 4 || !preg_match('~^\d\d\d\d.\d\d.\d\d~', $string)) {
      if (trim($string) == "") continue;
      if ($reverse == '1') {
        $stringPrev = '<br>'.trim(Utils::htmlChars($string)).''.$stringPrev;
      } else {
        echo trim(Utils::htmlChars($string)).'<br>';
      }
      
      //if (!empty($string)) {
      //  echo '<br /><span style="margin-left:20px;white-space:nowrap">'.$string.'</span>';
      //}
      continue;
    }
    list($date, $time, $ip, $username) = $a;
    if (empty($username)) {
      continue;
    }
    $text = mb_substr($string, strpos($string, $username) + mb_strlen($username));
    $tms = strtotime($time.' '.implode('.', array_reverse(explode('.', $date))));
    $ip = mb_substr($ip, 3);
    $date = date('d.m.Y', $tms);
    echo "<div style=\"white-space:nowrap; margin-bottom:5px\">";
    if ($previousDate != $date) {
      echo '<b>'.$date.'</b><br> ';
    }
    //echo '<br />';
    if ($withTime == '1') {
      echo '<span style="font-size:10px; color:#aaa">'.date('H:i:s', $tms).'</span>&nbsp;';
    }
    echo '<span>'.Utils::htmlChars($text).$stringPrev.'</span>';
    echo "</div>\n";
    $previousDate = $date;
    $stringPrev = '';
  }
}

else {

global $urlPage;
?>
<table class="table table-bordered b-instance-list" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th>&nbsp;</th>
    <th><a href="<?php $urlPage->setProperty(DA_URL_OBY, 'file'); echo $urlPage->getUrl() ?>">Файл</a></th>
    <th><a href="<?php $urlPage->setProperty(DA_URL_OBY, 'mtime'); echo $urlPage->getUrl() ?>">Изменен</a></th>
    <th><a href="<?php $urlPage->setProperty(DA_URL_OBY, 'size'); echo $urlPage->getUrl() ?>">Размер</a></th>
  </tr>
</thead>
<tbody>
<?php
$data = getfilesfromdir(DA_ROOT.'log', 0, false);
$files = array();
foreach ($data as $v) {
  if ($v == ".htaccess") continue;
  $path = DA_ROOT.'log/'.$v;
  $files []= array(
    'file' => $v,
    'size' => filesize($path),
    'mtime' => filemtime($path)
  );
}
$urlPage->setDefaultUrl();
$sort = $urlPage->GET(DA_URL_OBY) == null ? 'mtime' : $urlPage->GET(DA_URL_OBY);
array_assoc_sort(&$files, $sort, $isDesc=true, $isNumeric=true);

foreach ($files as $v) {
  extract($v);
?>
  <tr class="base">
    <td class="col-ref action-view"><a href="?log=<?php echo $file?>" title="Изменить"><i>&nbsp;</i></a></td>
    <td class="col-string"><?php echo $file?></td>
    <td class="col-string"><?php echo date('d.m.Y h:i:s', $mtime)?></td>
    <td class="col-string"><?php echo formatSize($size)?></td>
  </tr>
<?php
  }
?>
</tbody>
</table>
<?php
}


?>