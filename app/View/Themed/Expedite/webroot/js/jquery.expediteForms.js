/*	jQuery Expedite forms Plugin.
 *	
 *	@author Tanner Mckenney tmckenney7@outlook.com
 *	@description Converts forms into Ajax-Controlled components. 
 **/
;(function($) {
	"use strict";
	
	var __debug = false;
	
	/* Internal Functions (Private) */

	function debug(obj) {
		if (__debug) {
			try {
				console.log(JSON.stringify(obj));
			} catch(ex) {
				// Do Nothing
			}
		}
	}
	
	function trigger_error(error_obj, form) {	
		$('.loading').hide();
		$.each(error_obj, function(index, element) {					
			$(form).find('input[name*="' + index + '"], select[name*="' + index + '"]')
				.removeClass("modified")
				.addClass("error")
				.tooltip({ content: (element + "") });
		});
		if($('div.flash.error').size() == 0) {
			$('div.toasts')
				.empty()
				.append('<div class="error">Changes Were Not Saved. Check your fields. You may not have permission to update this section.</div>')
				.show().delay(3000).hide('drop', { direction: "up" }, 400, function() { 
					$('div.toasts').empty();
				});			
		}
	}
	
	function finalize() {
		if($('form.ajaxForm.modified, form .error').size() == 0) {
			location.reload();
		}
	}
	
	function updateUnSavedIndicator() {
		if($('input.modified, select.modified, textarea.modified').size() > 0) {
			$('.save-button').addClass('unsaved');
		} else {
			$('.save-button').removeClass('unsaved');
		}
	}
	
	$.updateUnSavedIndicator = function() {
		updateUnSavedIndicator();
	};
	
	/* jQuery Functions (Public) */
	
	/* MUCH needed function. Bind a change event to a selector, but update on page load. */
	
	$.fn.update = function(event) {
		return this.each(function(i, e) {
			event.call(e);
			$(e).change(event);
		});
	};
	
	/* Creates an AjaxForm object. */
	
	$.fn.ajaxForm = function() { 
		return this.filter("form").each(function(i, form) {
			if(!$(form).hasClass('ajaxForm')) {
				$(form).addClass('ajaxForm');
				$(form).removeClass('modified');
				$(form).find('input, select, textarea').change(function() {
					$(form).addClass('modified');
					$(this).addClass('modified');
					updateUnSavedIndicator();
				});
				$(form).save = function() {
					$(form).submit(); 
				};
				$(form).find('input[type="submit"]').each(function(index, button) { 
					$(this).click(function(event) { 
						event.preventDefault();
						$.savePage();
						return false;
					}); 
				});
				if($(form).find('input[type="file"]').size() > 0) {
					var name = 'form-' + new Date().getTime();
					$(form).append('<iframe id="' + name + '" name="' + name + '" style="display:none;"></iframe>');
					$(form).attr("target", name); 
					$(form).addClass("reload", name); 
					$(form).submit(function(event) {
						$(form).find('iframe[name="' + name + '"]').load(function() {	
							$(form).removeClass('modified');
							finalize();
						});
					});
				} else {
					$(form).submit(function(event) {
						event.preventDefault();
						$(form).find('.error').removeClass('error');
						$(form).find('div.msg').remove();
						$.ajax({
							type: $(form).attr("method"),
							url: $(form).attr("action"),
							data: $(form).serialize(),
							async: true,
							error: function(x) {
								debug(x);
							},  
							success: function(data) {
								debug(data); 
				
								if(typeof(data.errors) !== 'undefined') {
									trigger_error(data.errors, form);
								} else {
									$(form).removeClass('modified');
									$(form).find('input, select, textarea').removeClass('modified'); 
								}
								
								finalize();
							},
						});	
						return false;
					});
				}
			}
		});
	};
	
	/* Saves all form.ajaxForm on the page */
	
	$.savePage = function() {
		var forms = $('form.ajaxForm.modified'); 
		if($(forms).size() > 0) {
			$('.loading').show();
			$(forms).each(function(i, f) {
				$(f).submit();
			});
		}
	};
	
	/* Allows a field to control the display of a selector. */
	
	$.fn.toggleOnValue = function(selector, value) {
		return this.filter('input, select').each(function(i, e) {
			$(e).update(function() { 
				var x = $(this).val();
				if ((x !== null) && (x.toString().indexOf(value) != -1)) {
					$(selector).show();
				} else {
					$(selector).hide();
				}
			});
		});
	};
	
	/* Turns normal 'a' links into POSTs intead of GETs */
	
	$.fn.postLink = function(func) {
		if (typeof(func) === 'undefined') {
			func = (function() {
				return true;	
			}); 
		}
		return this.filter('a').each(function(i,a) {
			$(a).click(function(e) {
				e.preventDefault();
				if(func()) {
					jQuery.post(jQuery(a).attr("href"), { _method: "POST" }).always(function() {
						location.reload(); 	
					});
				}
				return false; 
			});
		});
	}
	
	/* Binds an Other option to fields. */
	
	$.fn.showOtherField = function(suffix) {
		if (typeof(suffix) === 'undefined') {
			suffix = '_other';
		}
		return this.filter('input').each(function(i,e) {
			var name = $(e).attr('name').replace(suffix, '');
			var control = $(e).parents('form').find('select[name*="' + name + '"]');
			$(control).toggleOnValue($(e).parent(), "Other");
		});	
	};
	
	/* Bind Long values in fields to show tooltip. */
	
	$.fn.longToolTip = function(maxchars) {
		if(typeof(maxchars) === 'undefined') {
			maxchars = 24;
		}
		$(this).tooltip({
			items: '*', 
			track: true,
			show: false,
			hide: false,
			content: function() {
				if($(this).is('input')) {
					if($(this).val().length > maxchars) {
						return $(this).val();
					} else {
						return false;
					}				
				} else {

					var selected = [];
					
					$(this).find('option:selected').each(function(i, e) { 
						selected.push($(e).text());
					});
					
					selected = selected.join(', ');
					
					if($(this).attr('multiple') == 'multiple') {
						selected = selected + ' <br /> (Hold Ctrl and Click to Select Multiple)';
					}

					var first = $(this).find('option:first').text();
					
					if(selected.length > maxchars) {
						return selected;
					} else if(first.length > maxchars){
						return first;
					} else {
						return false;
					}		
				}
			}
		});
	};
	
	/* Parse out commas in Numeric fields. */
	
	$.fn.removeCommasOnSubmit = function() {
		return this.each(function(i, e) {
			$(e).parents('form').submit(function(event) {
				event.preventDefault(); 
				$(e).val($(e).val().replace(/,/g, ''));
			});
		});
	};

})(jQuery);