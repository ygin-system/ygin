(function() {
  tinymce.create('tinymce.plugins.ygin_cleanPlugin', {
    preInit : function() {
      var url;
      tinyMCEPopup.requireLangPack();
      document.write('<script language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></script>');
    },
    init : function(ed, url) {
      var t = this;
      t.editor = ed; 
      // Register commands  
      ed.addCommand('ygin_cmd_clean', function() {
        ed.windowManager.open({file:url+"/i.htm",width:480,height:360,inline:1},{plugin_url:url});
      });

      // Register buttons
      ed.addButton('ygin_clean', {title : 'clean', cmd : 'ygin_cmd_clean', image : url + '/yginClean.gif'});
    },      
    getInfo : function() {
      return {
        longname : 'ygin clean',
        author : 'Digital Age',
        authorurl : 'http://cvek.ru',
        infourl : 'http://cvek.ru',
        version : "1"
      };
    }
  });  
  

  tinymce.PluginManager.add('ygin_clean', tinymce.plugins.ygin_cleanPlugin);
})();