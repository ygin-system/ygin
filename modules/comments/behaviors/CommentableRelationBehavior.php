<?php
class CommentableRelationBehavior extends CActiveRecordBehavior {
  public $idObject;
  public $idInstance;
  public function relationCountComment() {
    $sql = "SELECT count(*) as commentsCount FROM pr_comment WHERE id_object=:idObject AND id_instance=:idInstance and moderation = 1";
    $query = Yii::app()->db->createCommand($sql);
    $result = $query->queryAll(true, array(
        ':idObject' => $this->idObject,
        ':idInstance' => $this->idInstance,
      ));
    foreach($result as $row) {
      return $row['commentsCount'];
    }
  }
}