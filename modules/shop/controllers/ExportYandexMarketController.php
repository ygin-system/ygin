<?php

class ExportYandexMarketController extends Controller {

  public function actionIndex($key) {
    if ($key != $this->module->exportKey) {
      echo 'invalid key';
      return;
    }
    $file = Yii::app()->getRuntimePath().'/catalog_export_market.dat';
    if ($this->echoFile($file)) return;
    // генерируем новый файл и сразу выводим содержимое на экран
    if (!file_exists($file) || is_writable($file)) {
      $handle = fopen($file, 'w');
      if (!$handle) {echo 'can not write to file'; return;}
      $this->writeLine($handle, time());
      $this->writeLine($handle, 'id;type;available;url;price;currencyId;category;picture;vendor;model;store;delivery;description');
      $criteria = new CDbCriteria();
      $criteria->condition = 't.id_brand IS NOT NULL';
      $criteria->mergeWith($this->module->exportCriteria);
      $products = Product::model()->with('brand', 'mainPhoto')->findAll($criteria);
      $domain = Yii::app()->domain->getModel();
      $categories = ProductCategory::model()->getTree();
      foreach($products AS $product) {
        /**
         * @var $product Product
         * @var $category ProductCategory
         */
        $category = ($product->id_product_category == null ? null : $categories->getById($product->id_product_category));
        if ($category == null) continue;
        $product->category = $category;
        $name = str_replace(array("\n", "\r", ";", "\t", '"'), array(' ', ' ', ',', ' ', ''), $product->name);
        $this->writeElements($handle, array(
          $product->id_product,
          'vendor.model',
          'true',
          'http://'.$domain->getDomainName().$product->getUrl(),
          $product->getPriceWithMarkup(),
          'RUR',
          $category->name,
          ($product->image == null ? '' : 'http://'.$domain->getDomainName().$product->mainPhoto->getUrlPath()),
          ($product->id_brand == null ? '' : $product->brand->name),
          $name,
          'false',
          'true', // delivery
          str_replace(array("\n", "\r", ";", "\t", '"'), array(' ', ' ', ',', ' ', ''), $product->description),
        ));
      }
      fclose($handle);
      $this->echoFile($file);
    }
  }

  private function echoFile($file) {
    $ok = false;
    if (file_exists($file) && is_readable($file)) {
      $first = true;
      $handle = fopen($file, "r");
      while (!feof($handle)) {
        $line = trim(fgets($handle));
        if ($first) {
          $first = false;
          if (!is_numeric($line)) break;
          if (time() - intval($line) > $this->module->exportTimeout) {
            break;
          }
          $ok = true;
          continue;
        }
        // выводим содержимое файла
        if (trim($line) == '') continue;
        echo $line."\n";
      }
      fclose($handle);
    }
    return $ok;
  }

  private function writeLine($handle, $string) {
    fwrite($handle, $string."\n");
  }
  private function writeElements($handle, $array) {
    $count = count($array);
    $string = '';
    for($i = 0; $i < $count; $i++) {
      $string .= $array[$i];
      if ($count != ($i+1)) $string .= ';';
    }
    $this->writeLine($handle, $string);
  }

}
