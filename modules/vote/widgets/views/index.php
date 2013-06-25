<?php
$this->registerCssFile('vote-widget.css');
?>
<div class="b-vote-widget" id="vote_widget_<? echo $voting->id_voting; ?>">
  <h4><?php echo $voting->name; ?></h4>
<?php
  $this->render($view, array(
    'voting' => $voting,
    'voteCount' => $voteCount,
  ));
?>
</div>