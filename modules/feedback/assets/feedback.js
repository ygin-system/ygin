function cFaqAnswerShow() {
  $('.cFAQ .item .answer:first').css('display','block').addClass('cur');
  $('.cFAQ .item .ask').click( function() {
    if($(this).parent().find('.answer').length==0) {
      return;
    } 
    var h = $('.cFAQ .item .cur').eq(0);
   
    if(h != null && h.parent()[0] != $(this).parent()[0]) {
      h.slideToggle().removeClass('cur');
      $(this).parent().find('.answer').slideToggle('slow').addClass('cur');
    }
  });
}