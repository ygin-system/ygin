/**
 * Наши функции, встречающиеся больше, чем 1 раз
 */
function cleanCode(tmpC, d1, d2, d3, d4, d6, d6, d7, d8, d9) {
  tmpC = $('<div>' + tmpC + '</div>');//get jquery object

  //delete width, height
  if(typeof(d1) != "undefined" && d1){
    //tmpC.find('*[width]').not('img,object,iframe').removeAttr("width");
    //tmpC.find('*[height]').not('img,object,iframe').removeAttr("height");
    tmpC.find('*').not('img,object,iframe').css({width:'',  height:''});
  }
  
  //delete css paddings, margins
  if(typeof(d2) != "undefined" && d2){
    tmpC.find('*').css({margin:'', padding:''});
  }
  
  if(typeof(d3) != "undefined" && d3){
    tmpC.find('*').css({textIndent:'', fontSize:'', lineHeight:'', fontFamily:''});
  }
  
  //delete background
  if(typeof(d4) != "undefined" && d4){
    //tmpC.find('*[bgcolor]').removeAttr("bgcolor");
    tmpC.find('*').css('background','');
  }
  
  //delete border
  if(typeof(d5) != "undefined" && d5){
    //tmpC.find('*[border]').removeAttr("border");
    tmpC.find('*').css('border','');
  }
  
  //delete lang, class Mso
  if(typeof(d6) != "undefined" && d6){
    //tmpC.find('*[lang]').removeAttr("lang");
    tmpC.find("*[class*='Mso']").removeAttr("class");
  }
  
  //delete underline
  if(typeof(d7) != "undefined" && d7){
    /*tmpC.find('u').each(function () {
      $(this).replaceWith($(this).html());  
    });*/
    tmpC.find('*').each(function(){
      if ($(this).css('text-decoration') == 'underline') $(this).css('text-decoration','');
    });
  }

  tmpC.find('*').each(function(){
    if ($(this).attr('style') == '') $(this).removeAttr('style');
  });
  
  //delete &nbsp;
  if(typeof(d8) != "undefined" && d8){
    tmpC.html( tmpC.html().replace(/&nbsp;/g,' ') );
  }
  
  //delete comments
  if(typeof(d9) != "undefined" && d9){
    tmpC.html( tmpC.html().replace(/<!--.*-->/g, "") );
  }
  
  return tmpC.html();
}