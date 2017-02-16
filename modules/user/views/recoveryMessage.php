<?php
/* @var RecoverForm $recoverForm */
$tmpl =
"Здравствуйте! Вы выполнили запрос на восстановление пароля на сайте {siteName}\n".
"Ваш логин: {login}.\n".
"Ваш новый пароль: {password}.\n\n".
"---\n".
"Данное сообщение отправлено автоматически, отвечать на него не нужно.";

echo strtr($tmpl, array(
  '{siteName}' => Yii::app()->request->hostInfo,
  '{login}'    => $recoverForm->getUserModel()->name,
  '{password}' => $recoverForm->getNewPassword(),
));
?>