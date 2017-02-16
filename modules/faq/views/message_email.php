<?php
/**
 * @var $question Question
 */

$msg = "В разделе Вопрос-ответ отправлено новое сообщение.\n".
  "время: {time}\n".
  "имя: {name}\n".
  "e-mail: {email}\n".
  "текст сообщения:\n{msg}\n\n".
  "---\n".
  "Данное сообщение отправлено автоматически, отвечать на него не нужно.";

echo strtr($msg, array(
  '{time}'  => date('d.m.Y H:i', $question->ask_date),
  '{name}'  => $question->name,
  '{email}' => $question->email,
  '{msg}'   => $question->question,
));