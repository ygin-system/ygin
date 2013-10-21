<?php 
/*
 * Comment $model
*/

$str =
"Пользователь: {name}\n";
if (isset($model->comment_theme)) {
$str .= "Тема: {theme}\n";
}
$str .= "Текст комментария: {comment}\n".
"Редактировать комментарий в панели управления: {editLink}\n".
"Просмотреть на сайте: {viewLink}\n";

echo strtr($str, array(
  '{name}' => CHtml::encode($model->getUserName()),
  '{theme}' => CHtml::encode($model->comment_theme),
  '{comment}' => CHtml::encode($model->comment_text),
  '{editLink}' => Yii::app()->request->hostInfo."/admin/page/250/".$model->primaryKey."/view/67/",
  '{viewLink}' => Yii::app()->request->urlReferrer.'#comment-'.$model->primaryKey,
));
