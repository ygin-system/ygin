function replaceBanners(bannerPlaces) {
  for (var i = 0; i < bannerPlaces.length; i++) {
    var curBannerPlace = bannerPlaces[i];
    jQuery('#' + curBannerPlace.id).replaceWith(curBannerPlace.code);
    for (var j = 0; j < curBannerPlace.banners.length; j++) {
      var curBanner = curBannerPlace.banners[j];
      if (curBanner.interval == 0) {
        jQuery('#' + curBanner.id).replaceWith(curBanner.code);
      } else {
        (function(banner) {
          setTimeout(function(){jQuery('#' + banner.id).replaceWith(banner.code);}, banner.interval);
        })(curBanner);
      }
    }
  }
}