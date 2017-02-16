(function($){
	
	var options = {onAfterShowAllMessages: function(){}};
	var $originFavicons;
	
	var animateFavicon = function() {
	    $('link[rel$=icon]').remove();
	    $('head')
	      .append($('<link rel="shortcut icon" type="image/x-icon"/>')
	      .attr('href',  options['assetsUrl']+'nfavicon.gif'));
	};
	
	var restoreFavicon = function() {
		$('link[rel$=icon]').remove();
	    $('head')
	      .append($originFavicons.clone());
	}
	
	var beep = function() {
		try {
		  $("#messenger-audio")[0].play();
		} catch (e) { 
			//заглушка, если браузер не поддерживает проигрывание звука 
		}
	}
	
	var checkNewMessages = function() {
		$.ajax({
			'url': options['newMessagesUrl'],
			'type': 'get',
			'dataType': 'json',
			'success': function(data) {
				if (data.length > 0) {
					var senders = [];
					
					for (var i in data) {
						if ($('#messenger-sticker-' + data[i].id).length > 0) continue;
						
						if ($.inArray(data[i].sender, senders) == -1) {
							senders.push(data[i].sender);
						}
						$.daSticker({
							id: 'messenger-sticker-' + data[i].id,
							text: data[i].text, 
							type: data[i].type,
							sender: data[i].sender,
							sticked: true,
							onAfterRemove: function() {
								if ($('[id^=messenger-sticker]').length == 0) {
								  restoreFavicon();
								}
							}
					  });
						//вешаем на кнопку "Закрыть" обработчик о просмотре сообщения
						$('#messenger-sticker-'+ data[i].id+ ' .close').on('click', function() {
							var idMessage = $(this).closest('[id^=messenger-sticker]').attr('id').split('-')[2];
							$.post(
								options['readMessageUrl'],
								{id: idMessage}
							);
						});
						
					}
					animateFavicon();
				  beep();
				  options.onAfterShowAllMessages(senders);
				}
			}
		});
	};
	
	$.fn.messenger = function(o) {
		$.extend(options, o);
		$originFavicons = $('link[rel$=icon]').clone();
		$('<audio id="messenger-audio">'+
			  '<source src="'+options['assetsUrl']+'tada.mp3" type="audio/mpeg">' +
		      '<source src="'+options['assetsUrl']+'tada.ogg" type="audio/ogg; codecs=vorbis">' +
		    '<audio>').appendTo('body');
		
		setInterval(checkNewMessages, options['timeout']);
		return this;
	}
})(jQuery);