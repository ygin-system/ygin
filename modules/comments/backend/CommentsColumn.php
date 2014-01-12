<?php
Yii::import('ygin.modules.comments.backend.CommentEventHandler');

class CommentsColumn extends BaseColumn {

  public $htmlOptions = array('class'=>'ref');
  protected $commentsCount = array();

  public function init() {
    $ids = $this->grid->dataProvider->getKeys();
    $rows = Yii::app()->db->createCommand()
        ->select('id_instance AS id, count(*) AS cnt')
        ->from(CommentYii::model()->tableName())
        ->where(array(
          'and', 'id_object=:COMMENTS_OBJECT_ID',
          array('in', 'id_instance', $ids)
        ))
        ->group('id_instance')
        ->queryAll(true, array(':COMMENTS_OBJECT_ID' => $this->object->id_object));
    foreach ($rows AS $row) {
      $this->commentsCount[$row['id']] = $row['cnt'];
    }
  }

  protected function renderDataCellContent($row, $data) {
    $idInstance = $data->getIdInstance();
    $cnt = HArray::val($this->commentsCount, $idInstance, 0);
    $link = Yii::app()->createUrl(BackendModule::ROUTE_INSTANCE_LIST, array(
      ObjectUrlRule::PARAM_OBJECT => CommentYii::ID_OBJECT,
      CommentEventHandler::URL_PARAM_OBJECT => $this->object->id_object,
      CommentEventHandler::URL_PARAM_INSTANCE => $idInstance,
    ));
    echo CHtml::link('<i class="glyphicon glyphicon-comment"></i> '.$cnt, $link, array('title'=>'Комментарии'));
  }
}