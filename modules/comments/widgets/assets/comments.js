/**
 * jQuery Comments list plugin
 * @author Zasjadko Dmitry <segoddnja@gmail.com>
 */

;
(function($) {
  /**
 * commentsList set function.
 * @param options map settings for the comments list. Availablel options are as follows:
 * - deleteConfirmString
       * - approveConfirmString
 */
  $.fn.commentsList = function(options) {
    return this.each(function(){
      var settings = $.extend({}, $.fn.commentsList.defaults, options || {});
      var $this = $(this);
      var id = $this.attr('id');
      $.fn.commentsList.settings[id] = settings;
      //Выбор показа формы
      $.fn.commentsList.initForm(id);
      
     $this
      .delegate('.delete-comment', 'click', function(){
        
        var id = $($(this).parents('.b-comment-widget')[0]).attr("id");
        var $dialog = $('#addCommentDialog-'+id);
        if(confirm($.fn.commentsList.settings[id]['deleteConfirmString'])) {
          $.post($(this).attr('href'), {'idComment':$(this).attr('rel')})
           .success(function(data){
             data = $.parseJSON(data);
             $dialog.html(data["form"]);
             if(data["code"] === "success") {
               $.fn.commentsList.overdrawCommentList($dialog, data);
             }
           });
         }
         return false;
      })

      .delegate('.approve-comment', 'click', function(){
        var id = $($(this).parents('.b-comment-widget')[0]).attr("id");
        if(confirm($.fn.commentsList.settings[id]['approveConfirmString'])) {
          $.post($(this).attr('href'), {'idComment':$(this).attr('rel')})
           .success(function(data) {
             data = $.parseJSON(data);
             if(data["code"] === "success") {
               $(this).html('<a href="#">Удалить</a>');
             }
           });
        }
        return false;
      })
/*
      .delegate('input.error, textarea.error', 'keyup', function(){ 
        $(this).next('.errorMessage').remove();
        $(this).removeClass('error').parents('tr').find('td').eq(0).find('label.error').removeClass('error');
        return false;
      })
*/
      
      //свернуть раскрыть ветку
      .delegate('.minimize', 'click', function(){
        var idComment = $(this).attr('rel');
        $.fn.commentsList.showCommentBranch(idComment);
        return false;
      })
     /**
      * @deprecated
      */
      //заголовок комментов
/*     .delegate('.b-comment-tag', 'click', function(){
       $('img.gorizontal_loader').show();
       var idObject = $('.b-comment-tag > a').data('object'); 
       var idInstance = $('.b-comment-tag > a').data('instance');
       var widgetId = $('.b-comment-widget').attr('id');

       // отрисовываем дерево комментов
       $.getJSON('/yiicomments/view?idObject=' + idObject + '&idInstance=' + idInstance, function(data) {
         $('img.gorizontal_loader').hide();
         $('#'+widgetId).html(data["comments"]).find('.b-comment-list, #addCommentDialog-'+widgetId).slideDown();
         $('#addCommentDialog-'+widgetId).data('widgetID', widgetId);
         if (options.isGuest === false) {
           // Комменты отрисованы(просмотрены), значит делаем обновление непросмотренных комментов
           $.fn.commentsList.updateCountNewComment(idObject, idInstance);
         }
       });
       $this.undelegate('.b-comment-tag','click');
     })*/
      
      //Ответить
      .delegate('.add-comment', 'click', function(){
        var idComment = $(this).attr('rel');
        var id = $($(this).parents('.b-comment-widget')[0]).attr("id");
        $dialog = $("#addCommentDialog-"+id);
        var commentID = $(this).attr('rel');
        if(commentID) {
          $('.parent_comment_id', $dialog).val(commentID);
        }
        $.fn.commentsList.moveCommentFormToComment(id, idComment);
        return false;
      });
    });
  };
      
  $.fn.commentsList.defaults = {
    'deleteConfirmString':'Удалить комментарий?',
  };
      
  $.fn.commentsList.settings = {};
  
  // Инициализация формы
  $.fn.commentsList.initForm = function(id){
    var $dialog = $('#addCommentDialog-'+id);
    $('body').delegate('#'+id + ' form', 'submit', function(){
      $.fn.commentsList.postComment($('#addCommentDialog-'+id));
      return false;
    });
      $dialog.data('widgetID', id);
  }
      
  $.fn.commentsList.postComment = function($dialog){
    $(".b-comment-form .submit").button("loading");
    var $form = $(".b-comment-form", $dialog);
    $.post(
      $form.attr("action"),
      $form.serialize()
    ).success(function(data){
      $('.b-comment-form .submit').button('reset');
      data = $.parseJSON(data);
      $dialog.html(data[".b-comment-form"]);
      if(data["code"] == "success") {

        $.fn.commentsList.overdrawCommentList($dialog, data);
        /**
         * @deprecated
         */
/*      $('#'+id).html($(data["list"])).find('#'+$dialog.attr('id')).data('widgetID', id);
        var id = $dialog.data('widgetID');
        // После добавления коммента надо обновить количество новых комментов
        var idSet = $($('.b-comment-widget')[0]).attr('id');
        if ($.fn.commentsList.settings[idSet]['isGuest'] === false) {
          var idObject = $('.b-comment-tag > a').data('object'); 
          var idInstance = $('.b-comment-tag > a').data('instance'); 
          $.fn.commentsList.updateCountNewComment(idObject, idInstance);
        } */
      }
    });
  }
  /**
   * @deprecated
   */
  // Обновляем количество непросмотренных комментариев
/*  $.fn.commentsList.updateCountNewComment = function(idObject, idInstance) {
    var id = $($('.b-comment-widget')[0]).attr('id');
    $.post($.fn.commentsList.settings[id]['updateCommentUrl'], {'idObject' : idObject, 'idInstance' : idInstance});
    
  }*/
  
  //Перемещение формы по комментам
  $.fn.commentsList.moveCommentFormToComment = function(id, idComment) {
    $("#addCommentDialog-"+id).insertAfter($("#comment_" +idComment));
    /**
     * @deprecated
     */
    //$("#comment_" + idComment + " > .item .txt-body").show();
    //$("#comment_" + idComment + " > .item .minimize").html("Свернуть");
  }
  
  //Скрытие/раскрытие ветки с комментами
  $.fn.commentsList.showCommentBranch = function (idComment) {
    var commentBranch = $("#comment-" + idComment);
    var currentCommentBody = $("#comment-" + idComment + " > .item .txt-body");

    if (currentCommentBody.css('display') == "none") {
      var commentBody = commentBranch.find('.txt-body:hidden');
      commentBranch.find(".minimize i").removeClass().addClass('icon-minus');
    } else {
      var commentBody = commentBranch.find('.txt-body:visible');
      commentBranch.find(".minimize i").removeClass().addClass('icon-plus');
    }
    commentBody.slideToggle();
  }

  $.fn.commentsList.overdrawCommentList = function ($dialog, data) {
    var id = $dialog.data('widgetID');
    $('#'+id)
      .html($('#'+id, '<div>'+data["list"]+'</div>').html())
      .find('#'+$dialog.attr('id'))
      .data('widgetID', id);
    //после перерисовки комментов форма и лист комментов раскрыты
    $('#addCommentDialog-'+id +', .b-comment-list').show();
    var settings = $.fn.commentsList.settings[id];
  }
  
})(jQuery);

function commentHightlight() {
  $('.b-comments-list .item').bind("mouseenter", function () {
      $(this).addClass('over');
  }).bind("mouseleave", function () {
      $(this).removeClass('over');
  });
}
/**
 * @deprecated
 */
/*  
function initComments(widgetId, idObject, idInstance, isGuest) {
  
  var options = {'dialogTitle':'Добавить комментарий',
   'deleteConfirmString':'Удалить комментарий?',
   'approveConfirmString':'Утвердить комментарий?',
   'postButton':'Добавить комментарий',
   'cancelButton':'Отмена',
   'updateCommentUrl':'/yiicomments/updateComment',
   'isGuest':isGuest
  };
  
  $('#'+widgetId).commentsList(options);
  if(window.location.hash == "#comment-open") {
    $('.b-comment-tag').click();
  }
  
}*/

/*function getCountUnWatchingComments(idObject, idInstances, isGuest, type) {
  var count = idInstances.length;
  if (count>0) {
    var str = "";
    for (var id = 0; id<idInstances.length; id++) {
      str += "&id[]=" + idInstances[id];
    }
    $.getJSON('/yiicomments/countUnwatchCommentView?idObject=' + idObject + str, function(data) {
      for (var id = 0; id < idInstances.length; id++) {
        if ($('#instance-'+idInstances[id] + ' > a').length > 0) {
          $('#instance-'+idInstances[id] + ' > a').html("Новых").after(" ("+data[idInstances[id]] + ") ");
        } else {
          $('#instanceActual-'+idInstances[id] + ' > a').html("Новых").after(" ("+data[idInstances[id]] + ") ");
        }
      }
    })
  }

}*/
