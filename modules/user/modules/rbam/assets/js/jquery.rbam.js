/* SVN FILE: $Id: jquery.rbam.js 9 2010-12-17 13:21:39Z Chris $*/
/**
* Supporting JavaScript for RBAM
* 
* @copyright	Copyright &copy; 2010 PBM Web Development - All Rights Reserved
* @package		RBAM
* @since			V1.0.0
* @version		$Revision: 9 $
* @license		BSD License (see documentation)
*/
;(function($) {
	$.fn.rbam = function(){};
	$.fn.rbam.getErrorSummary = function(model, header, errors) {
		var error;
		var errorSummary = '<div class="error summary"><p>'+header+'</p><ul>';
		for (var i=0; i<errors.length; i++) {
			error = errors[i];
			jQuery('#'+model+'_'+error.attribute).addClass("error");
			errorSummary += "<li>"+error.label+": "+error.error+"</li>";
		}
		errorSummary += "</ul></div>";
		return errorSummary;
	};
	
	$.fn.rbam.showChildren = function(el) {
		var jRow = $(el).parents('tr').first();
		if (jRow.hasClass('showing-children')) {
			jRow.next().remove();
			jRow.removeClass('showing-children');
		}
		else {
			$.get(
				$('a',el).attr('href'),
				function(data) {
					jRow.after('<tr class="children" style="display:none;"><td colspan="'+jRow.children('td').length+'">'+data+'</td></tr>');
					jRow.next().show();
					jRow.addClass('showing-children');
				},
				'HTML'
			);
		}
	};
	
	$.fn.rbam.showParents = function(el) {
		var jRow = $(el).parents('tr').first();
		if (jRow.hasClass('showing-parents')) {
			jRow.prev().remove();
			jRow.removeClass('showing-parents');
		}
		else {
			$.get(
				$('a',el).attr('href'),
				function(data) {
					jRow.before('<tr class="parents" style="display:none;"><td colspan="'+jRow.children('td').length+'">'+data+'</td></tr>');
					jRow.prev().show();
					jRow.addClass('showing-parents');
				},
				'HTML'
			);
		}	
	};
	
	$.fn.rbam.relationships = function(strName, config) {
		String.prototype.surround = function(pre,post) {
			return (pre===false?'':pre)+this+(post==null?pre:(post===false?'':post));
		};
		
		$('body').ajaxError(function(e, xhr, settings, exception) {
			var aryMatches = xhr.responseText.match(/<p class="message">\s*(.+?)\s*<\/p>/);
			$('#rbam-dialog-done').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px -24px;"></span>'+aryMatches[1]+'</p>').dialog('option', 'title', config.error.title).dialog('open');
		});
		
			// there are nonchild items and child items
			var jParents = $('#parents');
			var jChildren = $('#children');
			var jUnrelated = $('#unrelated');
 		
		// Parents accept unrelated items
		jParents.droppable({
			accept: getAcceptable(jParents),
			activeClass: 'ui-droppable-active',
			hoverClass: 'ui-droppable-hover',
			drop: function(ev, ui) {
				addChild($(this), ui.draggable.text(), strName);
			}
		});

		// Children accept unrelated items
		jChildren.droppable({
			accept: getAcceptable(jChildren),
			activeClass: 'ui-droppable-active',
			hoverClass: 'ui-droppable-hover',
			drop: function(ev, ui) {
				addChild($(this), strName, ui.draggable.text());
			}
		});

		// Unrelated items accept items from parents and children
		jUnrelated.droppable({
			accept: '#children tbody tr td:first-child, #parents tbody tr td:first-child',
			activeClass: 'ui-droppable-active',
			hoverClass: 'ui-droppable-hover',
			drop: function(ev, ui) {
				if (ui.draggable.parents('.portlet').attr('id')==='parents') {
					removeChild(ui.draggable.parents('.portlet'), ui.draggable.text(), strName);
				}
				else {
					removeChild(ui.draggable.parents('.portlet'), strName, ui.draggable.text());
				}
			}
		});

		$.fn.rbam.relationships.makeDraggable(jParents);
		$.fn.rbam.relationships.makeDraggable(jChildren);
		$.fn.rbam.relationships.makeDraggable(jUnrelated);
		
		// determine what type(s) of items are acceptable to the given relationship
		function getAcceptable(jRelationship) {
			var aryAcceptable=new Array();
 			$('ul.tabs ~ div', jRelationship).each(function(index, el) {
				aryAcceptable[index]='#unrelated'+$(this).attr('id').substring(jRelationship.attr('id').length)+' tbody tr td:first-child';
 			});
 			return aryAcceptable.join(', ');			
		}

		// add a child to the parent
		function addChild(jRelationship, strParent, strChild) {
			$.getJSON(
				config.add.url,
				{parent:strParent, child:strChild},
				function(data) {
					if (jRelationship.attr('id')==='parents') {
						$.fn.yiiGridView.update($('#parents-'+data.parent.type+' .grid-view', jParents).attr('id'));
					}
					else {
						$.fn.yiiGridView.update($('#children-'+data.child.type+' .grid-view', jChildren).attr('id'));
					}
					updateUnrelated();
					// assignments grid updated by the done dialog
					
					if (data.status != 0) {
						var content = data.child.name.surround('"')+config.add.success.surround(' ')+data.parent.name.surround('"')+'.';
						var icon = 'circle-check';
					}
					else {
						var content = data.child.name.surround('"')+config.add.failure.surround(' ')+data.parent.name.surround('"')+'.';
						var icon = 'alert';
					}
					var jDone = jQuery("#rbam-dialog-done");
					jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+content+"$2").replace(/(ui-icon-).*?("|\s+)/i,"$1"+icon+"$2")).dialog('option', 'title', config.add.title).dialog('open');
				}
			);
		}

		// remove a child from the parent
		function removeChild(jRelationship, strParent, strChild) {
			$.getJSON(
				config.remove.url,
				{parent:strParent, child:strChild},
				function(data) {
					if (jRelationship.attr('id')==='parents') {
						$.fn.yiiGridView.update($('#parents-'+data.parent.type+' .grid-view', jParents).attr('id'));
					}
					else {
						$.fn.yiiGridView.update($('#children-'+data.child.type+' .grid-view', jChildren).attr('id'));
					}
					updateUnrelated();
					// assignments grid updated by the done dialog
					
					if (data.status != 0) {
						var content = data.child.name.surround('"')+config.remove.success.surround(' ')+data.parent.name.surround('"')+'.';
						var icon = 'circle-check';
					}
					else {
						var content = data.child.name.surround('"')+config.remove.failure.surround(' ')+data.parent.name.surround('"')+'.';
						var icon = 'alert';
					}
					var jDone = jQuery("#rbam-dialog-done");
					jDone.html(jDone.html().replace(/(<\/span>).*?(<\/p>)/i,"$1"+content+"$2").replace(/(ui-icon-).*?("|\s+)/i,"$1"+icon+"$2")).dialog('option', 'title', config.remove.title).dialog('open');
				}
			);
		}
		
		// Updates the unrelated items. Updates all tabs
		function updateUnrelated() {
			$.fn.yiiGridView.update($('#unrelated-role .grid-view', jUnrelated).attr('id'));
			$.fn.yiiGridView.update($('#unrelated-task .grid-view', jUnrelated).attr('id'));
			$.fn.yiiGridView.update($('#unrelated-operation .grid-view', jUnrelated).attr('id'));
		}
	};	

	// Make items in a grid view draggable
	$.fn.rbam.relationships.makeDraggable = function(jRelationship) {
		$('tbody tr td.item-name', jRelationship).draggable({
			helper: 'clone',
			opacity: 0.8,
			revert: 'invalid',
			cursor: 'move',
			containment: '#right-column'
		});
	};
	
	// afterAjax function for relationship grid views
	$.fn.rbam.relationships.afterGridUpdate = function(id) {
		var jRelationship = $('#'+id).parents('.portlet');
		$.fn.rbam.updateTabCounts(jRelationship);
		$.fn.rbam.relationships.makeDraggable(jRelationship);
	};

	// update the tab counts of a container
	$.fn.rbam.updateTabCounts = function(jContainer) {
		var aryGrids = $('.grid-view', jContainer).toArray();
		$('.tabs li span', jContainer).each(function(index) {
			var count = $('.summary span', aryGrids[index]).html();
			$(this).html((count==null?0:count));
		});
	};
})(jQuery);
