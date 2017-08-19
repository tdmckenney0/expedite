/* 

Expedite Global Javascript Functions

@requires: jQuery v1.9 / jQuery UI
@author: Tanner Mckenney
@created: March 25, 2013.

@note: The onload() function needs to be called every time the page is updated.

*/

var onload = function($) { 

		"use strict";
		
	/* Bind TinyMCE */
	
		tinymce.init({
			selector:'.content textarea:not(".copyPaste")',
			toolbar: 'bold italic underline forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent removeformat fontselect fontsizeselect',
			plugins: "autoresize contextmenu fullscreen image print lists hr colorpicker insertdatetime table wordcount anchor link textcolor",
			setup: function(editor) { 
				editor.on('blur', function(e) { 
					editor.save();
					$(editor.getElement())
						.addClass('modified')
						.parents('form')
							.addClass('modified')
					.end();
					$.updateUnSavedIndicator();
				});
				
				editor.on('submit', function(e) { 
					// Do Nothing!
				});
			}
		});
	
	/* Create button widget. */
	
		$('.actions a, a.button, button, input[type="submit"], input[type="button"], .button a').not('.ui-button, .mce-tinymce *').each(function(i, e) { 
			$(e).button();
			$(e).removeClass('button');
		});
		
	/* Bind Save Button */
	
		$('a.expedite-form-save').each(function() { 
			$(this).click(function(e) {
				e.preventDefault();
				$.savePage();
				return false; 	
			}); 
			$(this).removeClass('expedite-form-save');
		});
	
	/* Bind standard menu widget. */
	
		$('ul.expedite-menu').not('.ui-menu').each(function(i, e) { 
			
			$(e).menu().hide();
			$(e).data('boundBoxTimeOut', 0);
			
			// If Leave established Bounding box, remove after 1.5 seconds.
			
			$(e).mouseleave(function() { 
				$(e).data('boundBoxTimeOut', window.setTimeout(function() { 
					$(e).hide();
				}, 1500));
			});
		
			// If Return before timeout, remove it.
		
			$(e).mouseenter(function() { 
				window.clearTimeout($(e).data('boundBoxTimeOut'));
			});
			
			// If Click, hide.
			
			$(e).click(function() { 
				window.clearTimeout($(e).data('boundBoxTimeOut'));
				$(e).hide();
			});
		});
		
		$('a.expedite-menu-trigger').not('.set').each(function(i, e) { 
			$(e).click(function(ev) {
				ev.preventDefault();
				$(e).siblings('ul.expedite-menu').show().mouseleave();
				return false;
			});
			$(e).button('option', 'icons', { secondary: 'ui-icon-circle-arrow-s' });
			$(e).addClass('set');
		});
		
		$('a.home-menu').button('option', 'icons', { primary: 'ui-icon-home', secondary: 'ui-icon-circle-arrow-s' });
		$('a.plugin-menu, a.subsystem_menu').button('option', 'icons', { primary: 'ui-icon-triangle-1-e', secondary: 'ui-icon-circle-arrow-s' });
		$('a.plugin-button').button('option', 'icons', { primary: 'ui-icon-triangle-1-e' });
		$('a.add_new').button('option', 'icons', { primary: 'ui-icon-triangle-1-e', secondary: 'ui-icon-circle-plus' });
	
	/* Bind the DatePicker Calendar. */
	
		$('input.datepicker, div.datepicker input').not('[readonly], [disabled]').not('.mce-tinymce *').each(function(i, e) { 
			$(e).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,      
				changeYear: true,
				showAnim: ""
			});
			$(e).removeClass('datepicker');
		});
	
	/* Prevent Backspace in readonly fields */
	
		$('[readonly]').not('.backspacePrevent').each(function(i, e) { 
			$(e).keydown(function(ev) { 
				if(ev.which == 8) {
					ev.preventDefault();
					return false; 
				}
			});
			$(e).addClass("backspacePrevent");
		});
	
	/* Create the Tabs */
	
		$('.tabs').each(function(i, e) { 
			$(e).tabs({
				activate: function(event, ui) {
					if(!$(this).hasClass('nourl')) {
						var id = $(ui.newPanel).attr("id");
						window.location.hash = '#' + id;
					}	
				},
				load: function(event, ui) {
					onload($); 
				}
			});
			$(e).removeClass('tabs');
		});

	/* Collapsible sections */
	
		$('.accordion').each(function(i, e) { 
			$(e).accordion({ heightStyle: "content", collapsible: true, active: false });
			$(e).removeClass('accordion');
		});

	/* Create dataTables */
	
		$('table.data').not('.dataTable').each(function(i, e) { 
			$(e).dataTable({
				"sPaginationType": "full_numbers",
				"fnDrawCallback": function(oSettings) {
					onload($);
				},
				"bJQueryUI": true,
				"bDestroy": true,
				"bAutoWidth": false,
				"aaSorting": []
			});
			$(e).removeClass('data');
		});
	
	/* Create Delete Buttons */
	
		$('a.delete').not('.set').each(function(i, e) { 
			$(e).postLink(function() {
				return confirm("Are you sure you wish to delete this entry?");	
			});
			$(e).addClass('set');
		});	
	
	/* Create Post-Link functionality */
	
		$('a.postLink').each(function(i, e) { 
			$(e).postLink();
			$(e).removeClass('postLink');
		});
		
		$('.dataTables_wrapper').addClass("ui-widget-content");
	
	/* Bind Dialog controls */
	
		$('.ajax_dialog').each(function(i, element) { 
		
			$(element).click(function(ev) { 
				ev.preventDefault();
				$.get($(element).attr('href') + '?' + Math.random(), null, function(result) {
					
					var dialog = $('div.expedite-dialog');
					
					$('.ui-widget-overlay').remove();
					
					$(dialog).hide().width(10).html(result+ '<div class="clear">&nbsp;</div>');
					
					
					if($(dialog).find('.expedite-dialog-close').length < 1) {
						
						if($(dialog).find('.buttons').length < 1) { 
							$(dialog).append('<div class="buttons"></div>')
						} 
						
						$(dialog)
							.find('.buttons')
								.append('<a href="#" class="button expedite-dialog-close">&nbsp;&nbsp;Close&nbsp;&nbsp;</a>')
							.find('.submit')
								.css('display', 'inline');
					}
					
					$('.expedite-dialog-close').click(function(close) { 
						
						$(dialog).hide('drop', { direction: "up" }, 400, function() { 
							$(dialog).html('');
							$('.ui-widget-overlay').remove();
						});
					
						close.preventDefault();
					});

					onload($); 
					
					$('body').append('<div class="ui-widget-overlay ui-front">&nbsp;</div>');
					
					if($(dialog).width() > $('div.expedite-dialog div').width()) {
						$(dialog).width(900);
					} else {
						$(dialog).width($('div.expedite-dialog div').width());
					}
					
					$(window).resize(function() { 
						$(dialog).css('max-height', ($(window).height() - 100) + 'px');
					}); 
					
					$(dialog).show('drop', { direction: "up" }, 400, function() { 
					
						tinymce.init({
							selector:'textarea:not(".copyPaste")',
							toolbar: 'bold italic underline forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent removeformat fontselect fontsizeselect',
							plugins: "autoresize contextmenu fullscreen image print lists hr colorpicker insertdatetime table wordcount anchor link textcolor",
							setup: function(editor) { 
								editor.on('blur', function(e) { 
									editor.save();
									$(editor.getElement())
										.addClass('modified')
										.parents('form')
											.addClass('modified')
									.end();
									$.updateUnSavedIndicator();
								});
								
								editor.on('submit', function(e) { 
									// Do Nothing!
								});
							}
						});
					
						$(window).resize();
					});
				});	
			});
			
			$(element).removeClass('ajax_dialog');
		});
		
	/* Remove Commas on Submit */
	
		$('.currency input, .percent input, input[type="number"]').not('.ignore_commas').removeCommasOnSubmit(); //this must be bound before ajaxForm.
		
	/* Ajax Form */
	
		$('.content form, .expedite-dialog form').not(".no_ajax").ajaxForm();
		
	/* Other Field */
	
		$('input[name*="_other"]').showOtherField();
		
	/* Tooltips */
		
		$('input, select').not('.longToolTip').addClass("longToolTip").longToolTip(16);
		
	/* End */
}

/* 
	First Run on Page Hit.
*/

jQuery(function() {

	$('div.toasts').append($('div.toast'));
	
	if($('div.toasts div').size() > 0) {
		$('div.toasts').show().delay(3000).hide('drop', { direction: "up" }, 400, function() { 
			$('div.toasts').empty();
		});
	} else {
		$('div.toasts').hide(); 
	}

	onload(jQuery);
	$('.toolbar').show();
	$('.content').show();
	$('a.search_submit').click(function() { 
		$('div.search form').submit();
	});
});