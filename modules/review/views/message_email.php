<?php
/**
 * @var Review $review
 */

$msg = "Отправлен новый отзыв.\n".
  "время: {time}\n".
  "имя: {name}\n".
  "контакты: {email}\n".
  "текст сообщения:\n{msg}\n\n".
  "---\n".
  "Данное сообщение отправлено автоматически, отвечать на него не нужно.";

echo strtr($msg, array(
  '{time}'  => date('d.m.Y H:i', $review->create_date),
  '{name}'  => $review->name,
  '{email}' => $review->contact,
  '{msg}'   => $review->review,
));