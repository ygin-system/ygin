<?php
/**
 * @var $this SearchController
 */

$this->registerCssFile("search.css");
?>

<div class="b-search">

  <form class="form-search well" action="<?php echo Yii::app()->createUrl(SearchModule::ROUTE_SEARCH_VIEW); ?>" method="get">
    <div class="input-append">
      <input class="search-query span4" placeholder="Поиск" value="<?php echo CHtml::encode($query) ?>" name="query" autocomplete="off">
      <button class="btn btn-inverse" type="submit"><i class="glyphicon glyphicon-search icon-white"></i> Найти</button>
    </div>
  </form>
<?php
  if ($error != null) {
    echo '<div class="alert alert-error"><b>Ошибка:</b> '.$error.'</div></div>';
    return;
  }
  $inc = $paginator->getCurrentPage() * $paginator->getPageSize();
  $cResult = count($searchResult);
?>
  <div class="result-count">Найдено: <span class="badge"><?php echo $total; ?></span></div>
  <ol class="result-list" start="<?php echo ($inc+1) ?>">

<?php
  foreach ($searchResult AS $cur) {
    $title = $addTitle = "";
    $link = $content = null;
    
    $title = $cur->title;
    $link = $cur->link;
    $content = $cur->getContent();
    if (!is_null($link)) $title = '<a href="'.$link.'">'.$title.'</a>'.$addTitle;

    $this->renderPartial('/_item', array(
      'title' => $title,
      'content' => $content,
      'searchResult' => $cur,
    ));
  }
?>
  </ol>
<?php  $this->widget('LinkPagerWidget', array('pages' => $paginator,)); ?>
</div>