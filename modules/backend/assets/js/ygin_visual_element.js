 ////////////////////////////////
//Объект, содержащий данные о файлах
function DaFileList(idObject, idInstance, idProperty, prefix, idTmp) {
  this.idObject = idObject;
  this.idInstance = idInstance;
  this.idProperty = idProperty;
  this.idTmp = idTmp;
  this.files = new Array();
  this.prefix = prefix;
}

// static
DaFileList.init = function (prefix, idObject, idInstance, idTmp) {
  da_pictureDelete(prefix, 1, idObject, idInstance, idTmp, -1);
}
DaFileList.getAllFiles = function () {
  var result = new Array();
  var idFileType = null;
  if (arguments.length == 1) {
    idFileType = arguments[0];
  }
  if (typeof daFileList !== "undefined") {
    for (var i in daFileList) {
      var cur = daFileList[i];
      for (var k in cur.files) {
        var f = cur.files[k];
        if (idFileType == null || f["idFileType"] == idFileType) {
          result.push(f);
        }
      }
    }
  }
  return result;
}

DaFileList.prototype = {
  addFile : function(idFile, path, name, ext, idFileType) {
    var file = {};
    file["idFile"] = idFile;
    file["path"] = path;
    file["name"] = name;
    file["ext"] = ext;
    file["idFileType"] = idFileType;
    this.files[idFile] = file;
  },
  
  exists : function(idFile) {
    return (idFile in this.files);
  },
/*  
  getCountFile : function() {
    return this.files.length;
  },*/
  
  redraw : function() {
    var html = "";
    for (var i in this.files) {
      file = this.files[i];
      ext = file["ext"];
      if (ext == "") ext = "unk";
        else ext = "unk " + ext;
      html += '<li><a target="_blank" href="' + file["path"] + '" class="file-open ' + ext + '" title="' + file["name"] + '">' + file["name"] + '</a><b class="icon-remove icon-red remove" onclick="da_pictureDelete(\'' + this.prefix + '\', 2, ' + this.idObject + ', ' + this.idInstance + ', \'' + this.idTmp + '\', ' + file["idFile"] + '); fileDeleteAnimation(true, $(this));" title="удалить"></b></li>';
    }
    $('#'+this.prefix+'FileList').html(html).find('li').daFileUpload();
  }
}
///////////////////////////////////

function drawSingleFileLink(idObject, idInstance, idParam, linkFile, imgPath, formFileOpenForView, idFile, actDelete) {
  var text = '<a title="' + formFileOpenForView + '" target="_blank" rel="daG" href="' + linkFile + '">' + imgPath + '</a>';

  //Ссылка "Удалить" у файлов, обязательных для заполнения, должна отсутствовать
  if (typeof(idFile) != "undefined" && typeof(actDelete) != "undefined"){
    text += '<b class="icon-remove icon-red remove" onclick="da_pictureDelete(\'pfp' + idParam + '\', 3, ' + idObject + ', ' + idInstance + ', null, ' + idFile + '); fileDeleteAnimation(true, $(this)); return false;" title="'+actDelete+'"></b>';
  }
  //

  $(".image_" + idParam).html(text).parents('.controls').find(".field-file").daNotNullChange();
}

function antiCapsLock(txt){
  var r = trim( txt.toLowerCase() );
  firstLetter = "";
  if (txt.length > 0){ //Оставляем большую первую букву
    firstLetter = trim(txt).charAt(0);
    r = firstLetter + r.slice(1);
  }
  return r;
}

function trim(str){
  return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

function yginTranslit(ruText) {
    if ((ruText == "") || (trim(ruText) == "")) return "";
    var enText = ruText.toLowerCase();
    var separator = "_";

    if (separator != "_")
    {
        enText = enText.replace(/\_/g, separator);
    }
    else
    {
        enText = enText.replace(/\-/g, separator);
    }

    enText = enText.replace(/<(.*?)>/g, "");
    enText = enText.replace(/\&#\d+\;/g, "");
    enText = enText.replace(/\&\#\d+?\;/g, "");
    enText = enText.replace(/\&\S+?\;/g,"");
    enText = enText.replace(/['\"\?\.\!*$\#@%;:,=\(\)\[\]]/g,"");
    enText = enText.replace(/\s+/g, separator);
    enText = enText.replace(/\//g, separator);
    enText = enText.replace(/а/g, "a");
    enText = enText.replace(/б/g, "b");
    enText = enText.replace(/в/g, "v");
    enText = enText.replace(/г/g, "g");
    enText = enText.replace(/д/g, "d");
    enText = enText.replace(/е/g, "e");
    enText = enText.replace(/ё/g, "jo");
    enText = enText.replace(/ж/g, "zh");
    enText = enText.replace(/з/g, "z");
    enText = enText.replace(/и/g, "i");
    enText = enText.replace(/й/g, "y");
    enText = enText.replace(/к/g, "k");
    enText = enText.replace(/л/g, "l");
    enText = enText.replace(/м/g, "m");
    enText = enText.replace(/н/g, "n");
    enText = enText.replace(/о/g, "o");
    enText = enText.replace(/п/g, "p");
    enText = enText.replace(/р/g, "r");
    enText = enText.replace(/с/g, "s");
    enText = enText.replace(/т/g, "t");
    enText = enText.replace(/у/g, "u");
    enText = enText.replace(/ф/g, "f");
    enText = enText.replace(/х/g, "h");
    enText = enText.replace(/ц/g, "ts");
    enText = enText.replace(/ч/g, "ch");
    enText = enText.replace(/ш/g, "sh");
    enText = enText.replace(/щ/g, "sch");
    enText = enText.replace(/ъ/g, "");
    enText = enText.replace(/ы/g, "y");
    enText = enText.replace(/ь/g, "");
    enText = enText.replace(/э/g, "e");
    enText = enText.replace(/ю/g, "ju");
    enText = enText.replace(/я/g, "ya");
    enText = enText.replace(/[^a-z0-9-_]/g,"");
    enText = enText.replace(/\+/g, separator);
    enText = enText.replace(/\&/g,"");
    enText = enText.replace(/-$/g,"");
    enText = enText.replace(/_$/g,"");
    enText = enText.replace(/^_/g,"");
    enText = enText.replace(/^-/g,"");

    return enText;
}

////////////////////////////////
function openWinSelectInstance(link, ukey) {
  glbCurIdSelInst = ukey;
  var wnd = $(window);
  var t = (wnd.height()/2 - (wnd.height()-100)/2) + wnd.scrollTop();
  var l = (wnd.width()/2 - (wnd.width()-100)/2) + wnd.scrollLeft();
  var w = $(window).width()-100;
  var h = $(window).height()-100;
  
  $('body')
    .append('<div class="b-modal-wnd" style="top:'+t+'px; left:'+l+'px; width:'+w+'px; height:'+h+'px">' + 
      '<iframe style="width:'+w+'px; height:'+(h-45)+'px" src="'+link+'" id="'+ukey+'"></iframe>'+
      '<div><table class="btn"><tr><td class="btnLeft" style="background-position: left -96px;"></td>'+
      '<td class="btnCenter" style="background-position: left -121px;"><a onclick="closeWinSelectInstance(); return false;" href="#">OK</a>'+
      '<td class="btnRight" style="background-position: right -146px;"></td></tr></table></div>'+
      '</div>'+
    '<div class="b-modal-bg"></div>');
  
  $(".b-modal-wnd .btnCenter a").click(function() {
    closeWinSelectInstance(); return false;
  });
  
  //btnHighlightBind();
}
function closeWinSelectInstance() {
  $('.b-modal-wnd').remove();
  $('.b-modal-bg').remove();
}

function changeSelectedInstance(value, idInstance, instanceCaption) {
  var obj = glbSelecteInstance[glbCurIdSelInst];
  if (value) {
    obj.addItem(idInstance, instanceCaption);
  } else {
    obj.deleteItem(idInstance);
  }
}

////////////////////////////////
//Объект, содержащий данные о свойствах
function SelectInstanceObject(idProperty, notNull) {
  this.idProperty = idProperty;
  this.notNull = notNull;
  this.properties = new Array();
}

SelectInstanceObject.prototype = {
     addItem : function(key, text) {
       this.properties[key] = text;
       //Добавление только этого элемента в ul
       if (this.properties.hasOwnProperty(key)) {
        t = '';
        t += '<li id="li_' + this.idProperty + '_' + key + '">';
        t += '<input type="hidden" name="' + this.idProperty + '[]" value="' + key + '">' + this.properties[key];
        if (!this.notNull) t += '<b class="del icon-remove icon-red" onclick="glbSelecteInstance[\'' + this.idProperty + '\'].deleteItem(' + key + ');" title="удалить">&nbsp;</b>';
        t += '</li>';
        $("#multiItems_" + this.idProperty).prepend(t);
     }
     },

     deleteItem : function(value) {
       if (this.exists(value)) {
         /*
          * Такой способ работает плохо, сдвигает ключи массива
          * this.properties[idProperty].splice(value, 1);
         */
         delete this.properties[value];
         $("#multiItems_" + this.idProperty).find("#li_" + this.idProperty + '_' + value).remove();
       }
     },
     
     deleteAll : function(){
       this.properties = new Array();
       $("#multiItems_" + this.idProperty).html("");
     },
     
     setSingleItem : function(value, text) {
       this.deleteAll();
       this.addItem(value, text);
     },
     
     exists : function(value) {
       return (value in this.properties);
     }
}
////////////////////////////////


function showPhpScriptParam(id, cl) {
  $('.' + cl).hide();
  $(id).show();
}

function editDate(from, to, current, name, dw) {
  //dw [true, false] - direct write, т.е. прямой вывод в документ

  var res = '<select name="'+name+'">'; 
  for (i = from; i < to; i++) {
    iS = i;
    if (iS < 10) iS = "0"+iS;
    add = "";
    if (i == current) add = " selected";
    res += '<option value="'+i+'"'+add+'>'+iS+'</option>'; 
  }
  res += "</select>";
  if ((dw == null) || dw) document.write(res);
  else return res;
}

////////////////////////////////
// Загрузка файлов
function hangFileListUpload(selId, fileId, caseSensetive, objectParameters) {
  $(":file[name^='" + fileId + "']").change(function() {
    fileUploadCheck(selId, fileId, caseSensetive, objectParameters);
  });
}

/* Проверка загружаемых файлов на совпадение имён (регистронезависимо)
 * selId - ИД ul-а
 * fileId - ИД инпута для загрузки файла
 * caseSensetive - регистрозависимость имён
 * objectParameters - данные, пересылаемые скрипту
 */
function fileUploadCheck(selId, fileId, caseSensitive, objectParameters) {
  //В случае мультизагрузки файлов может быть несколько, и они могут совпасть по именам
  var fileNames = new Array();
  var files = document.getElementById(fileId).files;
  if ((typeof(files) != "undefined") && (typeof(files.length) != "undefined")) {
    for (i = 0; i < files.length; i ++) {
      fileNames.push(files[i].name);
    }
  } else fileNames.push(getFileName($('#'+fileId).val()));
  //

  var replaceOldFile = 0;
  
  var coincidence = new Array();
  $('#' + selId + ' a').each(function() {
  var count = fileNames.length;
  for (i = 0; i < count; i ++) {
      fileName = fileNames[i];
    if (caseSensitive){
      if ($(this).html() == fileName) {
        coincidence.push(fileName);
      }
    } else {
      if ($(this).html().toLowerCase() == fileName.toLowerCase()) {
        coincidence.push(fileName);
      }
    }
  }
  });
  
  var count = coincidence.length;
  if (count) {
  var word1 = 'Файл';
  var word2 = 'загружен';
  if (count > 1) {
    word1 = 'Файлы';
    word2 = 'загружены';
  }
  
    if (confirm(word1 + ' ' + coincidence.join(', ') + ' уже ' + word2 + ', заменить?')) {
      replaceOldFile = 1;
    }// else return false;
  }

  var prefix = objectParameters.prefix;

  //Настройки загрузки файла
  var options = {
      //Имя и id поля с файлом
      fileField: fileId,
      //Временное значение для новых вставляемых файлов
      tempValue: $('#temp_value').val(),
      //Дополнительные параметры
      params: {"replaceOldFile" : replaceOldFile},

      //Начали загрузку
      onSubmit: function(id, fileName) {
        fileUploadAnimation(true, fileId);
        
        if (DaFileUploader.isUploadXML()) {
          //Добавление div-а, где будет бегать progress
          $("#" + prefix + "_uploadAnimation").parent().after('<div id="' + prefix + '_progressbar"></div><div id="' + prefix + '_dataUpload"></div>');
          $("#" + prefix + "_progressbar").css("width", 200).css("height", 20);
        }
      },

      /** Сведения о процессе загрузки
       * id - внутренний id загружаемого файла
       * fileName - название файла
       * loaded - сколько байт загружено
       * total - размер файла в байтах
       */
      onProgress: function(id, fileName, loaded, total) {
        //метод форматирует значение из байтов в кБ, Мб и т.д.
        var text = qq.FileUploader.prototype._formatSize(total);
        if (loaded != total){
          var value = Math.round(loaded / total * 100);
          text = Math.round(loaded / total * 100) + '% из ' + text;
          
          //Занесение информации в progress (если браузер не поддерживает загрузку через XMLHttp, данный метод не вызовется)
          $("#" + prefix + "_progressbar").progressbar({ value: value });
          $("#" + prefix + "_dataUpload").html(text);
        }
      },
 
      //Окончание загрузки
      onComplete: function(id, fileName, responseJSON) {
        if ("script" in responseJSON) {
          eval(responseJSON["script"]);
        }
        if ("error" in responseJSON) {
          //Можно поместить свой показ полученного текста
          alert(responseJSON["error"]);
        }
      },
      
      onCompleteAll: function() {
        fileUploadAnimation(false, fileId);
        //Если браузер поддерживает загрузку, удалить созданные div-ы
        if (DaFileUploader.isUploadXML()) {
          $("#" + prefix + "_progressbar,#" + prefix + "_dataUpload").remove();
        }

        //Очистить поле от адреса загруженного файла
        $('#' + fileId).parent().html($('#' + fileId).parent().html());
        //Заново навесить функцию обработки
        hangFileListUpload(selId, fileId, caseSensitive, objectParameters);
        //       
      }
  };
  
  da_pictureUpload(options, objectParameters);
}

function hangSingleUpload(name, objectParameters) {
  $(":file[name='" + name + "']").change(function() {
    $(this).attr("id", $(this).attr("name"));
    fileSingleUpload($(this).attr("name"), objectParameters);
  });
}

function fileSingleUpload(fileId, objectParameters) {
  //Настройки загрузки файла
  var options = {
      //Имя и id поля с файлом
      fileField: fileId,
      //Временное значение для новых вставляемых файлов
      tempValue: $('#temp_value').val(),
      //Дополнительные параметры
      params: {"replaceOldFile" : true},

      //Начали загрузку
      onSubmit: function(id, fileName) {
        fileUploadAnimation(true, fileId);
        if (DaFileUploader.isUploadXML()) {
          //Добавление div-а, где будет бегать progress
          $("#" + fileId + "_uploadAnimation").parent().after('<div class="progress progress-striped active" id="' + fileId + '_progressbar"><div class="progress-bar" id="' + fileId + '_dataUpload"></div></div>');
        }
      },

      /** Сведения о процессе загрузки
       * id - внутренний id загружаемого файла
       * fileName - название файла
       * loaded - сколько байт загружено
       * total - размер файла в байтах
       */
      onProgress: function(id, fileName, loaded, total) {
        //метод форматирует значение из байтов в кБ, Мб и т.д.
        var text = qq.FileUploader.prototype._formatSize(total);
        if (loaded != total){
          var value = Math.round(loaded / total * 100);
          text = value + '% из ' + text;
          
          //Занесение информации в progress (если браузер не поддерживает загрузку через XMLHttp, данный метод не вызовется)
          $("#" + fileId + "_progressbar").progressbar({ value: value });
          $("#" + fileId + "_dataUpload").html(text);
        }
      },
 
      //Окончание загрузки
      onComplete: function(id, fileName, responseJSON) {
        fileUploadAnimation(false, fileId);
        //Если браузер поддерживает загрузку, удалить созданные div-ы
        if (DaFileUploader.isUploadXML()) {
          $("#" + fileId + "_progressbar").remove();
        }
        
        //Очистить поле от адреса загруженного файла
        $(':file[name="' + fileId + '"]').parent().html($(':file[name="' + fileId + '"]').parent().html());
        //Заново навесить функцию обработки
        hangSingleUpload(fileId, objectParameters);
        //
        
        if ("script" in responseJSON) {
          eval(responseJSON["script"]);
        }
        
        if ("error" in responseJSON) {
          //Можно поместить свой показ полученного текста
          alert(responseJSON["error"]);
        }
      }
  };
  da_pictureSingleUpload(options, objectParameters);
}
////////////////////////////////

// Анимация и блокирование кнопок при загрузке файлов
// enable - bool включить или выключить анимацию
// fileInputId - ИД инпута, через который загружается файл
function fileUploadAnimation(enable, fileInputId) {
  var actionButtons = $('#saveAndCloseButton, #acceptButton, #cancelButton');
  var upload = $('#'+fileInputId).parent().parent().find('.uploadAnimation');
  
  if (enable) {
    actionButtons.button("disable");
    if (DaFileUploader.isUploadXML() == false) upload.css('display','inline');
  } else {
    actionButtons.button("enable");
    if (DaFileUploader.isUploadXML() == false) upload.hide();
  }
}

/* Получение имени файла по его полному пути */
function getFileName(path) {
  fileName = "";
  for (i=path.length-1; i >= 0; i--){
    if ((path.charAt(i) != '/') && (path.charAt(i) != '\\')){
      fileName = path.charAt(i) + fileName;
    } else break;
  }
  return fileName;
}

/* Очищает все другие инпуты type="file" с классом input-file */
/*function filesUploadClearingBind() {
  $('.input-file').unbind('change').change(function(){
    $('.input-file').not(this).parent().html( $('.input-file').not(this).parent().html() );
    filesUploadClearingBind();
  });
}*/

// Анимация и блокирование кнопок при загрузке файлов
// enable - bool включить или выключить анимацию
// el - объект для анимации
function fileDeleteAnimation(enable, el){
  if (enable) el.addClass('ani').unbind('click').attr('onclick','');
  else $('.b-instance-edit-form .field-file-list-upload b').removeClass('ani');
}



/* Обработка нажатия на галочку в списке экземпляров объекта */
function booleanColumn(idInstance, idObject, idObjectParameter){
  $('#bool_'+idInstance+'_'+idObjectParameter).removeClass('icon-green').removeClass('icon-ok').removeClass('icon-red').removeClass('icon-remove').addClass('load');
  da_booleanColumn(idInstance, idObject, idObjectParameter);
}