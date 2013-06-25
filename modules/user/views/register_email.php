<?php
/* @var User $user */
$tmpl =
"Здравствуйте. На сайте {siteName} зарегистрировался новый пользователь:\n".
"ID: {id}.\n".
"Логин: {login}.\n".

"\n\n".
"---\n".
"Данное сообщение отправлено автоматически, отвечать на него не нужно.";

echo strtr($tmpl, array(
  '{siteName}' => Yii::app()->request->hostInfo,
  '{login}'    => $user->name,
  '{id}' => $user->id_user,
));
?>