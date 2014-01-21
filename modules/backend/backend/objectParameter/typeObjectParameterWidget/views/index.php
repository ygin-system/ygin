<?php

/**
 * @var $form CActiveForm
 * @var $this DropDownListWidget
 * @var $model DaActiveRecord
 */

echo $form->dropDownList($model, $attributeName, $this->data, $this->htmlOption);
echo $form->error($model, $attributeName);

$object = DaObject::getById(ObjectParameter::ID_OBJECT);

$fieldParam     = $object->getParameterObjectByField('field_name');
$parameterParam = $object->getParameterObjectByField('add_parameter');
$sqlParam       = $object->getParameterObjectByField('sql_parameter');

$modelName = get_class($model);

?>
<script type="text/javascript">
/**
 * В этой функции можно задать взаимосвязь между выбранным типом свойства и поведением других полей
 * Сейчас можно задать изменение заголовка и изменение типа поля
 * Однако, пока реализована генерация не всех типов (см. файл ajaxScripts/loadFormElement.php)
 */
function getDataByType(parameterType) {
  var caption = [];
  var type    = [];
  var visible = [];
  var value = [];

  // здесь обязательно указываются значения по умолчанию для полей
  caption['field_name'] = '<?php echo $fieldParam->getCaption()?>';
  caption['add_parameter']  = '<?php echo $parameterParam->getCaption()?>';
  type['add_parameter']     = '<?php echo $parameterParam->getType()?>';

  // далее идёт настроечная часть. В каждом блок для типа указывается поведение других полей формы
  // caption[ПОЛЕ] = 'ЗАГОЛОВОК'  -  это значит, что для такого-то поля надо установить такой-то заголовок
  // type[ПОЛЕ] = 'ТИП ПАРАМЕТРА'  -  это значит, что для такого-то поля надо установить такой-то тип параметра
  if (parameterType == <?php echo DataType::SEQUENCE; ?>) {
    value['not_null'] = '0';

    visible['is_additional'] = false;
    visible['hint'] = false;

    visible['default_value'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['search'] = false;
    visible['group_type'] = false;
    visible['sql_parameter'] = false;
    visible['not_null'] = false;

    caption['add_parameter'] = 'Доп. настройка: -1 - отображать только в самом объекте. ИД_ПАРАМЕТРА - только для этого группирующего объека';

    visible['caption'] = false;
    value['caption'] = 'п/п';
  }
  if (parameterType == <?php echo DataType::ID_PARENT; ?>) {
    type['add_parameter'] = <?php echo DataType::BOOLEAN; ?>;
    caption['add_parameter'] = 'Отображать для возможности перемещения экземпяров по иерархии';

    value['not_null'] = '0';

    visible['default_value'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['search'] = false;
    visible['group_type'] = false;
    visible['sql_parameter'] = false;
    visible['not_null'] = false;
  }
  if (parameterType == <?php echo DataType::ABSTRACTIVE; ?>) {
    //value['add_parameter'] = '2';

    visible['not_null'] = false;
    value['not_null'] = '0';

    //caption['field_name'] = 'Путь к визуальному элементу (относительно корня сайта)';
    //caption['sql_parameter'] = 'Имя класса визуального элемента';

    visible['add_parameter'] = false;
    visible['sql_parameter'] = false;
    visible['default_value'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['search'] = false;
    visible['group_type'] = false;

  }
  if (parameterType == <?php echo DataType::OBJECT; ?>) {
    caption['add_parameter'] = 'Объект';
    type['add_parameter'] = parameterType;

    caption['default_value'] = 'Значение по умолчанию (ИД экземпляра объекта)';
    caption['sql_parameter'] = 'SQL where-условие отобора экземпляров';

    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['search'] = false;
  }
  if (parameterType == <?php echo DataType::REFERENCE; ?>) {
    caption['add_parameter'] = 'Справочник';
    type['add_parameter'] = parameterType;

    caption['default_value'] = 'Значение по умолчанию (ИД элемента справочника)';
    caption['sql_parameter'] = 'SQL where-условие отобора элеметнов справочника';

    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
    visible['search'] = false;
  }

  if (parameterType == <?php echo DataType::FILES; ?>) {
    caption['add_parameter'] = 'Тип файла';
    type['add_parameter'] = parameterType;

    visible['default_value'] = false;
    visible['sql_parameter'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
    visible['search'] = false;
    visible['not_null'] = false;
    visible['name'] = false;
    visible['field_name'] = false;

    value['name'] = 'listFiles';
    value['field_name'] = '-';
    value['not_null'] = '0';
  }
  if (parameterType == <?php echo DataType::FILE; ?>) {
    caption['add_parameter'] = 'Тип файла';
    type['add_parameter'] = parameterType;

    visible['default_value'] = false;
    visible['sql_parameter'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
    visible['search'] = false;
  }
  if (parameterType == <?php echo DataType::TEXTAREA; ?> || parameterType == <?php echo DataType::EDITOR; ?>) {
    visible['sql_parameter'] = false;
    visible['add_parameter'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
  }
  if (parameterType == <?php echo DataType::BOOLEAN; ?>) {
    type['default_value'] = <?php echo DataType::BOOLEAN; ?>;

    value['not_null'] = '1';

    visible['sql_parameter'] = false;
    visible['add_parameter'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
    visible['search'] = false;
    visible['not_null'] = false;
  }
  if (parameterType == <?php echo DataType::TIMESTAMP; ?>) {
    visible['sql_parameter'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
    visible['search'] = false;

    caption['add_parameter'] = 'Без времени';
    type['add_parameter'] = <?php echo DataType::BOOLEAN; ?>;
  }
  if (parameterType == <?php echo DataType::VARCHAR; ?>) {
    visible['sql_parameter'] = false;
    visible['add_parameter'] = false;
    visible['group_type'] = false;
  }
  if (parameterType == <?php echo DataType::INT; ?>) {
    visible['sql_parameter'] = false;
    visible['add_parameter'] = false;
    visible['group_type'] = false;
    visible['need_locale'] = false;
    visible['search'] = false;
  }
  if (parameterType == <?php echo DataType::PRIMARY_KEY; ?>) {
    visible['default_value'] = false;
    visible['need_locale'] = false;
    visible['is_unique'] = false;
    visible['group_type'] = false;
    visible['search'] = false;
    visible['is_additional'] = false;
    visible['not_null'] = false;


    <?php if (YGIN_DEVELOP): ?>
    type['add_parameter'] = <?php echo DataType::BOOLEAN; ?>;
    caption['add_parameter'] = 'Разрешить редактировать';

    type['sql_parameter'] = <?php echo DataType::VARCHAR; ?>;
    caption['sql_parameter'] = 'Настройки (основное поле; поле родитель; префикс)';
    <?php else: ?>
    visible['add_parameter'] = false;
    visible['sql_parameter'] = false;
    <?php endif; ?>

    //caption['sql_parameter'] = 'Имя последовательности (по умолчанию пусто)';

    visible['caption'] = false;
    value['caption'] = 'id';
  }
  return {caption:caption, type:type, visible:visible, value:value};
}
// РЕАЛИЗАЦИЯ
//ставим на запуск после загрузки страницы
$(function(){
  $("select[name='<?php echo $this->getElementName(); ?>']").change(function() {
    changeParameterField($(this).val());
  });
  changeParameterField($("select[name='<?php echo $this->getElementName(); ?>']").val());
});

function changeParameterField(paramType) {
  var data = getDataByType(paramType);
  // Меняем типы полей
  for (var id in data.type) {
    var newType = data.type[id];
    if (getCurrentFieldTypeById(id) == newType) {
      continue;
    }
    var val = null;
    var element = $("[name='<?php echo $modelName; ?>["+id+"]']");
    if (id in data.value) {
      val = data.value[id];
    } else {
      val = element.val();
    }
    //document.title = 'Здесь будем менять у поля '+id+' тип='+newType;
<?php
  echo CHtml::ajax(array(
    'url'=>Yii::app()->createUrl('backend/engine/getObjectParameterSetting'),
    'data'=>array(
      'newType'=>'js:newType',  // новый тип
      'val'=>'js:val',  // значение
      'field'=>'js:id', // имя поля
      'id' => ($model->isNewRecord ? -1 : $model->getIdInstance()),
    ),
    'type'=>'POST',
    'dataType'=>'json',
    'success'=>'js:function(data){if (data.error !== undefined) {alert(data.error); return;} element.parent().html(data.html); }',
  ));
?>
  }

  // Меняем заголовки у полей
  for (var id in data.caption) {
    var name = data.caption[id];
    setAnimateFieldCaption(id, name);
  }
  // Меняем видимость у полей
  setAnimateFieldHide(id, true);
  for (var id in data.visible) {
    setAnimateFieldHide(id);
  }

  // Меняем значения у полей
  for (var id in data.value) {
    var el = $("[name='<?php echo $modelName; ?>["+id+"]']");
    el.val(data.value[id]);
    el.change();
    el.keyup();
  }
}
/**
 * Устанавливает заголовок для поля, если он не равен текущему
 * В этой функциия содержится реализация того, каким образом будет меняться заголовок у полей
 * @param integer Id параметра, к которому относится заголовок
 * @param string Новый заголовок для поля
 */
function setAnimateFieldCaption(fieldId, caption) {
  //точно не помню, то ли .parents('.b-object-property:first'), то ли  .parents('.b-object-property').first(), надо экспериментировать
  var cellObject  = $("*[name='<?php echo $modelName; ?>["+fieldId+"]']").parents('.b-object-property');
  var cellLabel   = cellObject.find('.control-label');
  if ((jQuery.trim(cellLabel.text()) == caption)) {
    return;
  }
  cellObject.fadeTo('slow', 0);
  window.setTimeout(function() {
    // Ищем и заменяем текст лабела
    var labelChildNodes = cellLabel.get(0).childNodes;
    for (var i=0; i < labelChildNodes.length; i++){
      if (labelChildNodes[i].nodeType == 3) {
        labelChildNodes[i].textContent = caption;
        break;
      }
    }
  }, 600, cellObject, caption);
  cellObject.fadeTo('slow', 1);
}
/**
 * Реализует механизм скрытия параметров объекта
 */
function setAnimateFieldHide(fieldId, showAll) {
  if (showAll) {
    $('.hiddenParameterField').show();
  } else {
    var trObject  = $("*[name='<?php echo $modelName; ?>["+fieldId+"]']").parents('.b-object-property');
    trObject.hide();
    trObject.addClass('hiddenParameterField');
  }
}

/**
 * Возвращает текущий тип поля по ИД, т.к. тип любого поля может меняться динамически
 * После генерации нового поля на ajax, его тип будет указан в титл, иначе берется значение по умолчанию для типа
 */
function getCurrentFieldTypeById(id) {
  var inputObject = $("[name='<?php echo $modelName; ?>["+id+"]']");
  var currentFieldType = inputObject.attr('title');
  if (currentFieldType == '' || typeof(currentFieldType) == 'undefined') {
    // вот здесь надо знать текущие значения по умолчанию для всех типов
    var p = {};
  <?php
  $params = $object->parameters;
  foreach ($params as $param) {
    echo 'p["'.$param->getFieldName().'"]='.$param->getType().'; ';
  }
  ?>
    currentFieldType = p[id];
  }
  return currentFieldType;
}
</script>
