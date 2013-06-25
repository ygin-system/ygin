<?php
/**
 * @var Feedback $feedback
 */

$msg = "Отправлено новое сообщение через форму обратной связи:\n".
  "время: {time}\n".
  "имя: {name}\n".
  "телефон: {phone}\n".
  "e-mail: {email}\n".
  "текст сообщения:\n{msg}\n\n".
  "---\n".
  "Данное сообщение отправлено автоматически, отвечать на него не нужно.";

echo strtr($msg, array(
  '{time}'  => date('d.m.Y H:i', $feedback->date),
  '{name}'  => $feedback->fio,
  '{phone}' => $feedback->phone,
  '{email}' => $feedback->mail,
  '{msg}'   => $feedback->message,
));