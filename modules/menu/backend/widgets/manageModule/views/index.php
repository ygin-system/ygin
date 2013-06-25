<?php

/**
 * @var $form CActiveForm
 * @var $this DropDownListWidget
 * @var $model SiteModuleTemplate
 */
$idInstance = $model->getIdInstance();

$modules = SiteModule::model()->resetScope()->findAll();
if (count($modules) == 0) return;

$collection = new DaActiveRecordCollection($modules);

//Модули есть
$places = $model->modulePlaces;

// Уже задействованные модули
$currentIdModules = array();
$placesArray = array();
foreach($places AS $place) {
  $currentIdModules[] = $place->id_module;
  $placesArray[$place->place][] = $place;
}

// Получили в массиве nid модули, приписанные каким-либо местам
//+ в $idUpdatedModules идентификаторы этих модулей (пригодится позднее при выводе модулей из архива)
echo '<div id="modulesSeqPlace">
      <div class="span6">
                <div id="placeNonVisible" class="b-widget-place well">
                  <h4>Не используемые модули</h4>
                  <ul>';

// Если остались модули, которые не видны
$position = 0;
foreach($modules AS $m) {
  $id = $m->getIdInstance();
  if (!in_array($id, $currentIdModules)) {
    echo '<li id="module_'.$id.'">
                    <input type="hidden" value="" name="mod_'.$id.'_seq" class="contSeq">
                    <input type="hidden" value="" name="mod_'.$id.'_plc" class="contDid">
                    <span class="label label-important"><sup>'.++$position.'</sup> '.$m->name.'</span>
                  </li>';
  }
}
echo '    </ul>
                </div>
              </div>';

// Пробег по всем положениям модулей
$ref = ReferenceElement::model()->byReference(32)->findAll();

echo '<div class="span6">';
foreach ($ref as $r) {
  $idModulePlace = $r->getIdReferenceElement();
  $value = $r->getValue();
  echo '<div class="b-widget-place well" id="place_'.$idModulePlace.'">
                  <h4>'.$value.'</h4>
                  <ul>';

  // После заголовка выводим модули, соответствующие данному местоположению
  if (array_key_exists($idModulePlace, $placesArray)) {
    $arrayItem = $placesArray[$idModulePlace];
    $i = 0;
    foreach($arrayItem AS $v) {
      $id = $v->id_module;
      $i++;
      $module = $collection->itemAt($id);
      echo '<li id="module_'.$id.'">
                      <input type="hidden" value="'.$v->sequence.'" name="mod_'.$id.'_seq" class="contSeq">
                      <input type="hidden" value="'.$v->place.'" name="mod_'.$id.'_plc" class="contDid">
                      <span class="label label-success"><sup>'.$i.'</sup> '.$module->name.'</span>
                    </li>';
    }
  }
  echo '  </ul>
              </div>';
}
echo '</div>
         </div> <!-- #modSeqPlace -->';
Yii::app()->clientScript->registerScript('admin.widgetPlace.init', '
          $(".b-widget-place ul").sortable({
              connectWith: ".b-widget-place ul",
              placeholder: "highlight",
              stop: function (event, ui) {
                  $(".b-widget-place").each(function () {
                      m = 1;
                      var did = $(this).attr("id").substr(6, $(this).attr("id").length - 6);
                      $(this).find("li").each(function () {
                          $(this).find("sup").text(m);
                          $(this).find(".contSeq").val(m);
                          $(this).find(".contDid").val(did);
                          m++;
                      })
                  })
              }
          }).disableSelection();
        ', CClientScript::POS_READY);
