<?php
/**
 * @var $model Offer
 */

$msg =
  "Оформлена новая заявка на покупку товара:\n".
  "время: {time}\n".
  "имя: {name}\n".
  "телефон: {phone}\n".
  "e-mail: {email}\n".
  "комментарий покупателя: {comment}\n".
  "{offer_text}\n\n".
  "---\n".
  "Данное сообщение отправлено автоматически, отвечать на него не нужно.";

 echo strtr($msg, array(
    '{time}'       => date('d.m.Y H:i', $model->create_date),
    '{name}'       => $model->fio,
    '{email}'      => $model->mail,
    '{phone}'      => $model->phone,
    '{comment}'    => $model->comment,
    '{offer_text}' => $model->offer_text,
  ));
