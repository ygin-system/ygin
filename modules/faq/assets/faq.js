/***********************************
 **********   Вопрос-ответ    ******
 ***********************************/
function FAQ(){}

// Список вопроса-ответа
FAQ.container  = null;
FAQ.maxHeight  = 183; // Максимальная высота вопроса или ответа

/* Запуск */
FAQ.init = function(existsPrice){
  FAQ.container  = $(".b-faq");
  FAQ.collapseAskAns();
}

/* Сворачиваем вопросы и ответы, чтобы не занимали много места */
FAQ.collapseAskAns = function(existsPrice){
  FAQ.container.find('.ask, .ans').each(function(){
    if ($(this).height() >  FAQ.maxHeight){
      $(this).height( FAQ.maxHeight );
      $(this).after('<button class="btn btn-mini expend">развернуть</button>');
    }
  });
  FAQ.container.find('.expend').live('click', function(){
    $(this).prev().height('auto');
    $(this).remove();
  })
}