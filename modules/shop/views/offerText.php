<?php
$offerText = "Заявка:\n\n";
$sum = 0;
foreach ($products AS $product) {
  $cost = $product->getOfferSum();
  $sum += $cost;

  $offerText .= "Наименование товара: ".$product->name."
  Артикул: ".$product->code."
  Остаток: ".$product->remain."
  Цена: ".$product->getPriceWithMarkup()."
  Количество: ".$product->countInCart."
  Стоимость: ".($cost)."

  ";
}
$offerText .= "------\nИтого: ".$sum;
echo $offerText;