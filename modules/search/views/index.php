<?php
/**
 * @var $this SearchController
 */

$this->registerCssFile("search.css");
?>

<div class="b-search">
  <form class="panel panel-warning search-form" action="<?php echo Yii::app()->createUrl(SearchModule::ROUTE_SEARCH_VIEW); ?>" method="get">
    <div class="panel-heading">
      <div class="form-group col-sm-10">
        <input class="form-control" placeholder="Поиск" value="<?php echo CHtml::encode($query) ?>" name="query" autocomplete="off">
      </div>
      <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></i> Найти</button>
    </div>
  </form>

<?php
  if ($error != null) {
    echo '<div class="alert alert-danger"><b>Ошибка:</b> '.$error.'</div></div>';
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