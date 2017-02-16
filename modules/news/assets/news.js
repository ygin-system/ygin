function cNewsCategoryBind(){
  $('.b-news-category').buttonset()
    .find('a.active').addClass('ui-button-disabled ui-state-disabled').click(function(){return false});
}