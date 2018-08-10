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
					jQuery(editor.getElement())
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

		jQuery('.actions a, a.button, button, input[type="submit"], input[type="button"], .button a').not('.ui-button, .mce-tinymce *').each(function(i, e) {
			jQuery(e).button();
			jQuery(e).removeClass('button');
		});

	/* Bind Save Button */

		jQuery('a.expedite-form-save').each(function() {
			jQuery(this).click(function(e) {
				e.preventDefault();
				$.savePage();
				return false;
			});
			jQuery(this).removeClass('expedite-form-save');
		});

	/* Bind standard menu widget. */

		jQuery('ul.expedite-menu').not('.ui-menu').each(function(i, e) {

			jQuery(e).menu().hide();
			jQuery(e).data('boundBoxTimeOut', 0);

			// If Leave established Bounding box, remove after 1.5 seconds.

			jQuery(e).mouseleave(function() {
				jQuery(e).data('boundBoxTimeOut', window.setTimeout(function() {
					jQuery(e).hide();
				}, 1500));
			});

			// If Return before timeout, remove it.

			jQuery(e).mouseenter(function() {
				window.clearTimeout(jQuery(e).data('boundBoxTimeOut'));
			});

			// If Click, hide.

			jQuery(e).click(function() {
				window.clearTimeout(jQuery(e).data('boundBoxTimeOut'));
				jQuery(e).hide();
			});
		});

		jQuery('a.expedite-menu-trigger').not('.set').each(function(i, e) {
			jQuery(e).click(function(ev) {
				ev.preventDefault();
				jQuery(e).siblings('ul.expedite-menu').show().mouseleave();
				return false;
			});
			jQuery(e).button('option', 'icons', { secondary: 'ui-icon-circle-arrow-s' });
			jQuery(e).addClass('set');
		});

		jQuery('a.home-menu').button('option', 'icons', { primary: 'ui-icon-home', secondary: 'ui-icon-circle-arrow-s' });
		jQuery('a.plugin-menu, a.subsystem_menu').button('option', 'icons', { primary: 'ui-icon-triangle-1-e', secondary: 'ui-icon-circle-arrow-s' });
		jQuery('a.plugin-button').button('option', 'icons', { primary: 'ui-icon-triangle-1-e' });
		jQuery('a.add_new').button('option', 'icons', { primary: 'ui-icon-triangle-1-e', secondary: 'ui-icon-circle-plus' });

	/* Bind the DatePicker Calendar. */

		jQuery('input.datepicker, div.datepicker input').not('[readonly], [disabled]').not('.mce-tinymce *').each(function(i, e) {
			jQuery(e).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				showAnim: ""
			});
			jQuery(e).removeClass('datepicker');
		});

	/* Prevent Backspace in readonly fields */

		jQuery('[readonly]').not('.backspacePrevent').each(function(i, e) {
			jQuery(e).keydown(function(ev) {
				if(ev.which == 8) {
					ev.preventDefault();
					return false;
				}
			});
			jQuery(e).addClass("backspacePrevent");
		});

	/* Create the Tabs */

		jQuery('.tabs').each(function(i, e) {
			jQuery(e).tabs({
				activate: function(event, ui) {
					if(!jQuery(this).hasClass('nourl')) {
						var id = jQuery(ui.newPanel).attr("id");
						window.location.hash = '#' + id;
					}
				},
				load: function(event, ui) {
					onload(jQuery);
				}
			});
			jQuery(e).removeClass('tabs');
		});

	/* Collapsible sections */

		jQuery('.accordion').each(function(i, e) {
			jQuery(e).accordion({ heightStyle: "content", collapsible: true, active: false });
			jQuery(e).removeClass('accordion');
		});

	/* Create dataTables */

		jQuery('table.data').not('.dataTable').each(function(i, e) {
			jQuery(e).dataTable({
				"sPaginationType": "full_numbers",
				"fnDrawCallback": function(oSettings) {
					onload(jQuery);
				},
				"bJQueryUI": true,
				"bDestroy": true,
				"bAutoWidth": false,
				"aaSorting": []
			});
			jQuery(e).removeClass('data');
		});

	/* Create Delete Buttons */

		jQuery('a.delete').not('.set').each(function(i, e) {
			jQuery(e).postLink(function() {
				return confirm("Are you sure you wish to delete this entry?");
			});
			jQuery(e).addClass('set');
		});

	/* Create Post-Link functionality */

		jQuery('a.postLink').each(function(i, e) {
			jQuery(e).postLink();
			jQuery(e).removeClass('postLink');
		});

		jQuery('.dataTables_wrapper').addClass("ui-widget-content");

	/* Bind Dialog controls */

		jQuery('.ajax_dialog').each(function(i, element) {

			jQuery(element).click(function(ev) {
				ev.preventDefault();
				$.get(jQuery(element).attr('href') + '?' + Math.random(), null, function(result) {

					var dialog = jQuery('div.expedite-dialog');

					jQuery('.ui-widget-overlay').remove();

					jQuery(dialog).hide().width(10).html(result+ '<div class="clear">&nbsp;</div>');


					if(jQuery(dialog).find('.expedite-dialog-close').length < 1) {

						if(jQuery(dialog).find('.buttons').length < 1) {
							jQuery(dialog).append('<div class="buttons"></div>')
						}

						jQuery(dialog)
							.find('.buttons')
								.append('<a href="#" class="button expedite-dialog-close">&nbsp;&nbsp;Close&nbsp;&nbsp;</a>')
							.find('.submit')
								.css('display', 'inline');
					}

					jQuery('.expedite-dialog-close').click(function(close) {

						jQuery(dialog).hide('drop', { direction: "up" }, 400, function() {
							jQuery(dialog).html('');
							jQuery('.ui-widget-overlay').remove();
						});

						close.preventDefault();
					});

					onload(jQuery);

					jQuery('body').append('<div class="ui-widget-overlay ui-front">&nbsp;</div>');

					if(jQuery(dialog).width() > jQuery('div.expedite-dialog div').width()) {
						jQuery(dialog).width(900);
					} else {
						jQuery(dialog).width(jQuery('div.expedite-dialog div').width());
					}

					jQuery(window).resize(function() {
						jQuery(dialog).css('max-height', (jQuery(window).height() - 100) + 'px');
					});

					jQuery(dialog).show('drop', { direction: "up" }, 400, function() {

						tinymce.init({
							selector:'textarea:not(".copyPaste")',
							toolbar: 'bold italic underline forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent removeformat fontselect fontsizeselect',
							plugins: "autoresize contextmenu fullscreen image print lists hr colorpicker insertdatetime table wordcount anchor link textcolor",
							setup: function(editor) {
								editor.on('blur', function(e) {
									editor.save();
									jQuery(editor.getElement())
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

						jQuery(window).resize();
					});
				});
			});

			jQuery(element).removeClass('ajax_dialog');
		});

	/* Remove Commas on Submit */

		jQuery('.currency input, .percent input, input[type="number"]').not('.ignore_commas').removeCommasOnSubmit(); //this must be bound before ajaxForm.

	/* Ajax Form */

		jQuery('.content form, .expedite-dialog form').not(".no_ajax").ajaxForm();

	/* Other Field */

		jQuery('input[name*="_other"]').showOtherField();

	/* Tooltips */

		jQuery('input, select').not('.longToolTip').addClass("longToolTip").longToolTip(16);

	/* End */
}

/*
	First Run on Page Hit.
*/

jQuery(function() {

	jQuery('div.toasts').append(jQuery('div.toast'));

	if(jQuery('div.toasts div').size() > 0) {
		jQuery('div.toasts').show().delay(3000).hide('drop', { direction: "up" }, 400, function() {
			jQuery('div.toasts').empty();
		});
	} else {
		jQuery('div.toasts').hide();
	}

	onload(jQuery);
	jQuery('.toolbar').show();
	jQuery('.content').show();
	jQuery('a.search_submit').click(function() {
		jQuery('div.search form').submit();
	});
});
