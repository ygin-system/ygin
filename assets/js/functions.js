function refreshImage(idTeg, id) {
  refreshCapchaImage(idTeg, id);
}
function refreshCapchaImage(idTeg, id) {
  jQuery('#'+idTeg).attr("src", '/antispam.php?id='+id+'&i = '+Math.floor(Math.random()*100000));
}

function checkEmail(email) {
  return /^(([a-z\d][a-z\d\-\_\.]*)?[a-z\d](\.([a-z\d][a-z\d\-\_]*)?[a-z\d])*)+@(([a-z\d][a-z\d\-\_]*)?[a-z\d](\.([a-z\d][a-z\d\-\_]*)?[a-z\d])*)$/i.test(email);
}

function checkdate(month, day, year) {
  var myDate = new Date();
  myDate.setFullYear( year, (month - 1), day );

  return ((myDate.getMonth()+1) == month && day<32); 
}

function getJQueryAjax(arg, idJQuery, showErrors) {
  var args = Array.prototype.slice.call(arg);
  $.php("/admin/engine/ajax/", {"jqueryMode": idJQuery, "data": JSON.stringify(args), "showErrors": showErrors});
}

function getValumsFileUpload(options, idFileUpload) {
  options.action = "/admin/engine/ajax/?fileUpload=" + idFileUpload;
  var uploader = new DaFileUploader(options);
}

function addMultipleAttr(fileField) {
  var input = document.createElement('input');
  input.type = 'file';

  if ('multiple' in input && typeof File != "undefined") {
    element = $("#" + fileField);
    if (element.length == 0) element = $(":file[name='" + fileField + "']");
    if (element.length != 0) {
      element.attr("name", fileField + "[]");
      element.attr("multiple", "multiple");
      //element.attr("max", 40);
      //В некоторых браузерах (в частности Opera 11.11) без этой строчки не срабатывает
      element.parent().html(element.parent().html());
    }
  }
}

////////////////////////////////
//Объект, содержащий настройки загрузки файлов
function FileUploadSettings() {
  this.settings = new Array();
}

FileUploadSettings.prototype = {
  add : function(settings) {
    this.settings.push(settings);
  },
  
  findSettings : function(objectParameters) {
    //Обязательно есть пункты id_object, id_parameter. id_add_parameter под вопросом
    var idObject = objectParameters.idObject;
    var idParameter = objectParameters.idParameter;

    var settings = null;
    var count = this.settings.length;
    for (i = 0; i < count; i ++) {
      var item = $.extend({}, this.settings[i]);
      
      if (item.id_object == idObject && item.id_parameter == idParameter) {
        //Настройки стали ненужными
        delete item.id_object;
        delete item.id_parameter;
        //Третий параметр необязателен
        if (typeof(objectParameters.idAddObject) != "undefined") {
          //Отбор по нему всё-таки должен быть
          if (typeof(item.id_add_object) == "undefined" || item.id_add_object != objectParameters.idAddObject)
            continue; else delete item.id_add_object;
        }
        
        settings = item;
        break;
      }
    }
    
    return settings;
  }
}
///////////////////////////////////