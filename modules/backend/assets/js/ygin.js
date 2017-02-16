
/* Выполняется после загрузки страницы */
function adminDrawInit(){
  //instanceSubDataBind();  //Добавление событий для рисования подчинённых сущностей
  //btnBind();//События для кнопок
  //notNullBind();//Событие обработки обязательных полей
  //checkBoxToggleBind();//Обработка событий для переключающих видимость чекбоксов
  aPageSwBind();//Обработка событий для переключателя страниц
  //aDatePickerBind();//Обработка событий для поля с датой и временем
  //aCacheOptionsBind();//Обработка опций кэширования
  //daHintBind(); // Заменяем все стандартные хинты браузера на красивые
  $('#rbam').daRBAMSexy();
}










/* Удаление переведённых данных в данной локализации
localizationObject определяется в instance_admin_draw.php
*/
function admDeleteLocalizationData(idObj, idInst) {
  if (confirm('Внимание! Информация для текущей локализациии будет безвозвратно удалена. Продолжить?')){
    $.daLoadingData('show');
    da_deleteLocalizationData(idObj, idInst);
  }
  return false;
}


//Обработка событий для переключателя страниц
function aPageSwBind(){
  $('.aPageSw .pageRec').change(function(){
    alert('/engine/js/ygin.js:69 строка; Тут должно на аяксе смениться количество отображаемых записаей');
  });
}


function aCacheOptionsBind(){
  $('.aCacheMode .btn').click(function(){
    $(this).parents('.admCacheOptions').find('.cache-mode-settings').slideUp();
    var rel = $(this).attr('rel');
    $('#'+rel).slideDown();
  });
  $('.aCacheInDB').click(function(){
    var dbSettings = $(this).attr('rel');
    if ($(this).is(':checked')){
      $('#'+dbSettings).slideDown();
    } else {
      $('#'+dbSettings).slideUp();
    }
  });
}




























/***********************
 * Новые скрипты
 */



/*
 * Показать сообщение пользователю
 * text - текст сообщения
 * type - [0 - просто сообщение; 1 - сообщение об ошибке; 2 - успешное действие]
 * time - время показа в секундах (по умолчанию 3)
 * sticked - не пропадёт, пока не закроет пользователь
 * Пример: $.daSticker({text:"Привет, Мир!", type:"success", sticked:true});
 */
jQuery.daSticker = function( options ) {
  var options = jQuery.extend({
    type    : "info",
    time    : 5000,
    sticked : false,
  },options);

  var icon     = "";
  var msgClass = "";

  switch (options.type){
    case "info":
      icon     = '<i class="glyphicon glyphicon-info-sign"></i> ';
      msgClass = ' alert-info';
      break;
    case "error":
      icon     = '<i class="glyphicon glyphicon-remove-sign icon-red"></i> ';
      msgClass = ' alert-error';
      break;
    case "success":
      icon     = '<i class="glyphicon glyphicon-ok-sign icon-green"></i> ';
      msgClass = ' alert-success';
      break;
  }

  var stickers = $('#jquery-stickers'); // начинаем работу с главным элементом
  if (!stickers.length) { // если его ещё не существует
    $('body').prepend('<div id="jquery-stickers"></div>'); // добавляем его
    var stickers = $('#jquery-stickers');
    var $buttonsBar = $('.bar-fixed');
    var bottom = 0;
    //если есть фиксированные кнопки с действиями, то нужно отрисовать стикеры над ними
    if ($buttonsBar.size() > 0) {
      bottom = $buttonsBar.height() + 10;
    }
    stickers.css('position','fixed').css({right:'20px',bottom: bottom}); // позиционируем
  }
  var stick = $('<div class="stick"></div>'); // создаём стикер
  if (options.id) {
  stick.attr('id', options.id);
  }
  stickers.append(stick); // добавляем его к родительскому элементу
  stick.addClass('alert' + msgClass); // если необходимо, добавляем класс
  stick.html(icon + options.text); // вставляем сообщение
  if (options.sticked) { // если сообщение закреплено
    var exit = $('<button class="close" data-dismiss="alert">×</button>');  // создаём кнопку выхода
    stick.prepend(exit); // вставляем её перед сообщением
    exit.click(function(){  // при клике
      stick.fadeOut('slow', function(){ // скрываем стикер
        $(this).remove(); // по окончании анимации удаляем его
        if (options.onAfterRemove) {
          options.onAfterRemove();
        }
      })
    });
  } else { // если же нет
    setTimeout(function(){ // устанавливаем таймер на необходимое время
      stick.fadeOut('slow', function(){ // затем скрываем стикер
        $(this).remove(); // по окончании анимации удаляем его
        if (options.onAfterRemove) {
          options.onAfterRemove();
        }
      });
    }, options.time);
  }
  
  return this;
}

/*
 * Заменяем все стандартные хинты браузера на красивые
 */
jQuery.daHintBind  = function() {
  $('[rel="popover"]').popover({placement:'bottom'});
  $('[rel="tooltip"]').tooltip();
  $('.navbar .navbar-brand').tooltip({placement:'bottom'});
}

/*****
 * Перезагрузка текущей страницы 
 */
jQuery.daReloadPage = function() {
  var url_bit = window.location.pathname + "?i=" + Math.floor(Math.random()*100000);
  window.location = url_bit.replace( new RegExp( "&amp;", "g" ) , "&" );
}

















/**
/* Процесс ожидания ajax запроса с полным блокированием экрана
 * Пример: $.daLoadingData('show');
 */
var methods = {
  show : function() {
    $('body').append('<img id="loadingD" style="position:absolute; top:50%; left:50%" src="/engine/admin/gfx/loading_s.gif" alt="">');
    $('#loadingD').modal({'backdrop':'static', 'keyboard':false});
  },
  hide : function() {
    $('#loadingD').modal('hide').remove();
  },
};

jQuery.daLoadingData = function( method ) {
  if ( methods[method] ) {
    return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
  } else if ( typeof method === 'object' || ! method ) {
    return methods.show.apply( this, arguments );
  } else {
    $.error( 'Метод ' +  method + ' не существует в $.daLoadingData' );
  }
}




/*******
 * Рисование всплывающих меню для подчинённых сущностей 
 **/
var tim;
menuTimer = function(el) {
  window.clearInterval(tim);
  tim = setInterval(function(){
    $(el).fadeOut('slow');
    window.clearInterval(tim);
  }, 500);
}

jQuery.fn.daSubData = function( options ) {
  return this.each(function(){
    var actionSubData = $(this);
    actionSubData.find('i').css('cursor','pointer')
      .mouseover(function(){
        $('.action-sub-data ul').hide();
        window.clearInterval(tim);
        rel = $(this).attr('rel');
        $('#'+rel).slideDown('fast',function(){
          actionSubData.find('ul:not("[id=\''+rel+'\']")').hide();
        });
      })
      .mouseout(function(){
        menuTimer('#'+$(this).attr('rel'));
      });
    actionSubData.find('ul')
      .mouseover(function(){window.clearInterval(tim)})
      .mouseout(function(){menuTimer('#'+$(this).attr('id'))});
  });
}


/**
 * Разворачивает менюшки, перечисленные в куках
 */
jQuery.fn.daAccordionMenu = function( options ) {
  var options = jQuery.extend({
    activeItemClass     : 'active',
    accordionClass      : 'panel',
    accordionBodyClass  : 'panel-collapse',
    openItemClass       : 'in',
    collapsedItemClass  : 'collapsed',
    togglerClass        : 'panel-heading',

  },options);

  return this.each(function() {
    // Отмечаем текущую категорию меню
    $(this).find('.'+options.activeItemClass).parents('.'+options.accordionClass).find('.'+options.togglerClass).addClass(options.activeItemClass).removeClass(options.collapsedItemClass);

    // Блокируем меню, которое пользователь ранее сознательно открыл
    $(this).find('.'+options.accordionBodyClass).each(function(){
      var idMenuCategory = $(this).attr('id');
      var openedCategory = $.cookie('daMenuCategoty['+idMenuCategory+']');
      if (openedCategory == 1) $(this).parents('.'+options.accordionClass).find('.'+options.togglerClass+'.collapsed').click();
    });
    

    // Схлопываем всё лишнее
    $(this).find('.'+options.togglerClass).click(function(){
      var accordionBody = $(this).parents('.'+options.accordionClass).find('.'+options.accordionBodyClass);
      var curShlop = $(this).hasClass(options.collapsedItemClass);
      var idMenuCategory = accordionBody.attr('id');
      $.cookie('daMenuCategoty['+idMenuCategory+']', (curShlop?1:null), {expires:1000, path:'/'});
    });

  });
};


/**
 * Обновление левого меню в системе управления 
 */
jQuery.fn.daUpdateMenu = function( options ) {
  return this.each(function() {
    var that = $(this);
    // TODO урл формировать динамически в контроллере
//    $.getJSON('/admin/updateMenu/', {idObject : options.idObject, idObjectView : options.idObjectView }, function(data) {
    $.getJSON(options.url, {idObject : options.idObject, idObjectView : options.idObjectView }, function(data) {
      if (data.html !== undefined) {
        that.html(data.html).daAccordionMenu();
      }
    });
  });
};


/**
 * Обработка событий изменения обязательных свойств
 */
jQuery.fn.daNotNullChange = function( options ){
  var options = jQuery.extend({
    fileFieldClass         : 'field-file',
    fileFieldUploadedClass : 'field-file-uploaded',
    fileFieldParentClass   : 'controls',
    fieldParentClass       : 'form-group',
    errorMessageClass      : 'label-message',
    successClass           : 'has-success',
    errorClass             : 'has-error',
  },options);

  return this.each(function(){

      var isError = !$(this).val();

      // TinyMCE textarea check
      if ( ($(this).get(0).tagName.toLowerCase() == 'textarea') && ($('#'+$(this).attr('id')+'_ifr').length)){
        var ifr = $('#'+$(this).attr('id')+'_ifr');
        var tinyMCEText = '';
        if ( ifr.length > 0 ){
          var ifrCont = $('<div>'+document.getElementById( ifr.attr('id') ).contentWindow.document.body.innerHTML+'</div>');
          tinyMCEText = ifrCont.text();
          if (tinyMCEText) isError = false;
          else {
/* На php, видимо, делается strip_tags, поэтому нельзя сохранить просто теги
            ifrCont.find('br').remove().end().find('p').remove();
            if (ifrCont.html()) isError = false;
            else isError = true;
*/
            isError = true;
          }
          
        }
      }

      // File element
      if ( $(this).hasClass(options.fileFieldClass) ){
        if ( $(this).parents('.'+options.fileFieldParentClass).find('.'+options.fileFieldUploadedClass).html() ){
          isError = false;
        }
      }

      var parent = $(this).parents('.'+options.fieldParentClass); // Для обычных элементов
      if ( !parent ) parent = $(this).parent();      // Для прочих неожиданных случаев
      var messageBox = $(this).find('.'+options.errorMessageClass); // Место для вывода ошибки

      if (isError){
        messageBox.show();
        parent.removeClass(options.successClass).addClass(options.errorClass);
      } else {
        messageBox.hide();
        parent.removeClass(options.errorClass).addClass(options.successClass);
      }
    });
};

/**
 * Включаем возможность перетаскивания ячеек таблицы с целью изменения сортировки
 **/
jQuery.fn.daInstanceSequence = function( options ) {
  var options = jQuery.extend({
    highlightClass : 'highlight',
  },options);

  return this.each(function(){

  var that = $(this);
  that.find('tbody').sortable({
      cursor               : 'move',
      opacity              : 0.4,
      placeholder          : options.highlightClass,
      forcePlaceholderSize : true,
      tolerance            : 'pointer',
      axis                 : 'y',
      handle               : '.sorter',
      update               : function(event, ui) {
        if (options['isAjax']) that.daUpdateSequence({'idObject':options.idObject});
      },
      start                : function(event, ui) {
        var firstTrTd = $('.'+options.highlightClass).parent().find('tr:first:not(".'+options.highlightClass+'") > td');
        var tdNum = firstTrTd.length;
        var tdHeight = firstTrTd.height();
        var add = "";
        for (var i=0; i < tdNum; i++) add += '<td style="height:'+tdHeight+'px"></td>';
        $('.'+options.highlightClass).append(add);
      }
    });
  });
};

jQuery.fn.daUpdateSequence = function( options ) {
  var options = jQuery.extend({
    successMessage    : "Порядок сортировки изменён",
    rowPrefix         : "ygin_inst_",
  },options);
  return this.each(function(){
    var m_seq = {};
    var seqItems = $(this).find('tr[id^="'+options.rowPrefix+'"]');
    for (var i=0; i < seqItems.length; i++) {
      m_seq[$(seqItems[i]).attr("id")] = i;
    }
    da_sortInstances(options.idObject, m_seq);
    //$.daSticker({text:options.successMessage, type:"success"});
  });
};


/***
 * Проверка обязательных полей перед сохранением
 */
jQuery.fn.daCheckNotNullFields = function( options ) {
  var options = jQuery.extend({
    parentErrorClass : "has-error",
  },options);

  var checkResult = true;
  this.each(function(){
    var errorParent = $(this).parents('.'+options.parentErrorClass);
    if (errorParent.length > 0){
      checkResult = false;
      if ( !$(this).next().hasClass('label-message') )
        $(this).after('<br class="label-message"><span class="label label-danger label-message">'+options.messageText+'</span>');
      alert(options.alertText);
    }
  });
  return checkResult;
};



/***
 * Обработка событий загрузки файлов
 */
jQuery.fn.daFileUpload = function( options ) {
  var options = jQuery.extend({
    removeButtonClass : "remove",
    fileOpenClass     : "file-open",
  },options);

  return this.each(function(){
    var int;
    var b;

    $(this).unbind('mouseover').unbind('mouseout')
      .mouseover(function(){ $(this).find('.'+options.removeButtonClass).fadeIn('slow'); })
      .mouseout(function(){
        clearInterval(int);
        b = $(this).find('.'+options.removeButtonClass);
        int = setInterval(function(){ b.fadeOut(); clearInterval(int); }, 500);
      })
      .find('.'+options.fileOpenClass).unbind('mouseover').unbind('mouseout')
        .mouseover(function(){ clearInterval(int); })
        .mouseout(function(){
          clearInterval(int);
          b = $(this).parent().find('.'+options.removeButtonClass);
          int = setInterval(function(){ b.fadeOut(); clearInterval(int); }, 500);
        }).end()
      .find('.'+options.removeButtonClass).unbind('mouseover').unbind('mouseout')
        .mouseover(function(){ clearInterval(int); })
        .mouseout(function(){
          clearInterval(int);
          b = $(this);
          int = setInterval(function(){ b.fadeOut(); clearInterval(int); }, 500);
        });
  });
};





/*****
 * Делаем плавающую панель с кнопками Сохранить
 */
jQuery.fn.daFixedActionBarBind = function( options ) {
  var options = jQuery.extend({
    barClass      : "bar",
    barFixedClass : "bar-fixed",
    smallButtonClass : "btn-xs",
  },options);

  return this.each(function(){
    var actionBar = $(this);
    var buttonSetPosition = actionBar.offset().top+actionBar.height();
    $(window)
      .scroll(function(){
        if ($(this).scrollTop()+$(this).height() < buttonSetPosition){
          actionBar.find('.'+options.barClass).addClass(options.barFixedClass);
          actionBar.find('.btn').addClass(options.smallButtonClass);
        } else {
          actionBar.find('.'+options.barClass).removeClass(options.barFixedClass);
          actionBar.find('.btn').removeClass(options.smallButtonClass);
        }
      })
      .keydown(function(event){
        if (event.keyCode == "13" && event.ctrlKey == true && event.shiftKey == true) {
          $("#acceptButton").click();
        } else if (event.keyCode == "13" && event.ctrlKey == true) {
          $("#saveAndCloseButton").click();
        } else if (event.keyCode == "27" && event.ctrlKey == true) {
          $("#cancelButton").click();
        }
      });
    $(window).scroll();
  });
}



/* Удаление экземпляра объекта */
jQuery.fn.daDeleteRecord = function( options ) {
  return this.each(function(){
    if (confirm(options.text)) {
      var deleteAction = $(this).addClass("process").blur();
      da_deleteRecord(options.idObject, options.idInstance);
    }
  });
}


/* Внедряем элементы бутстрапа в RBAM */ 
jQuery.fn.daRBAMSexy = function() {
  return this.each(function(){
    $('#rbam .button, #rbam .buttons input,  #rbam :button, #rbam :submit')
      .removeClass('button')
      .addClass('btn')
      .parents('.buttons')
      .removeClass('buttons');
    $('#rbam form').addClass('well');
  });
}