(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

jQuery(document).ready(function($) {

	// Open the ShortCode popup when the button is clicked
	$('#ss-shortcode-popup-btn').click(function() {
		$('#ss-shortcode-popup').fadeIn();
	});

	// Close the ShortCode popup when the close button is clicked
	$('#ss-shortcode-close-btn').click(function() {
		$('#ss-shortcode-popup').fadeOut();
	});
	
	// Open the Login Settings popup when the button is clicked
	$('#ss-login-setting-popup-btn').click(function() {
		$('#ss-login-setting-popup').fadeIn();
	});

	// Close the Login Settings popup when the close button is clicked
	$('#ss-login-setting-close-btn').click(function() {
		$('#ss-login-setting-popup').fadeOut();
	});

	// Open the Custom Header/Footer popup when the button is clicked
	$('#ss-custom-header-popup-btn').click(function() {
		$('#ss-custom-header-popup').fadeIn();
	});

	// Close the Custom Header/Footer popup when the close button is clicked
	$('#ss-custom-header-close-btn').click(function() {
		$('#ss-custom-header-popup').fadeOut();
	});

	// Open the Custom Header/Footer popup when the button is clicked
	$('#ss-custom-function-btn').click(function() {
		$('#ss-custom-function-popup').fadeIn();
	});

	// Close the Custom Header/Footer popup when the close button is clicked
	$('#ss-custom-function-close-btn').click(function() {
		$('#ss-custom-function-popup').fadeOut();
	});

	// Open the Change Default Email Id popup when the button is clicked
	$('#ss-default-mail-btn').click(function() {
		$('#ss-default-mail-popup').fadeIn();
	});

	// Close the Change Default Email Id popup when the close button is clicked
	$('#ss-default-mail-close-btn').click(function() {
		$('#ss-default-mail-popup').fadeOut();
	});

    // AJAX Function for saving details
	jQuery('body').on('change blur','.ss-form-input', function() {
		ss_toolkit_ajax_call();
	});

	jQuery('body').on('click','.ss-save-btn', function() {
		ss_toolkit_ajax_call();
	});

	jQuery('body').on('click','.ss-custom-function-btn',function(){
		ss_toolkit_ajax_call();
	});

	jQuery('body').on('click','.ss-content-save-btn',function(){
		ss_toolkit_ajax_call();
	});

	jQuery('body').on('click','.ss-email-save-btn',function(){
		ss_toolkit_ajax_call();
	});

	function ss_toolkit_ajax_call(){
		jQuery('.ss_toolkit_message').text('Please wait...').css('display','block');

		var from_toolkit_form = jQuery(".uk-active #from_toolkit_form").val();

		var ss_login = (jQuery('#ss_login').is(":checked"))?1:0;
		var ss_dashboardwidget = (jQuery('#ss_dashboardwidget').is(":checked"))?1:0;
		var ss_shortcode = (jQuery('#ss_shortcode').is(":checked"))?1:0;

		var sstoolkit_removal = (jQuery('#sstoolkit-removal').is(":checked"))?1:0;
		var spotlight_access = (jQuery('#spotlight-access').is(":checked"))?1:0;

		var ss_api_key = jQuery('#ss_api_key').val();
		var ss_google_map_api = jQuery("#ss_google_map_api").val();

		var ss_rss_feed_link = (jQuery('#ss_rss_feed_link').is(":checked"))?1:0;
		var ss_rss_feed_link_promotion = (jQuery('#ss_rss_feed_link_promotion').is(":checked"))?1:0;
		var ss_background_image = jQuery("#ss-backgroud-image").val();

		var ss_head_foot_content = (jQuery("#ss_head_foot_content").is(":checked"))?1:0;
		var ss_custom_functions = (jQuery("#ss_custom_functions").is(":checked"))?1:0;

		var ss_custom_functions_value = [];
		var ss_custom_function_switch_value = [];
		var ss_custom_function_id = [];

		var ss_header_content = jQuery('#ss-header-content').val();
		var ss_footer_content = jQuery('#ss-footer-content').val();

		var ss_default_mail = jQuery('#ss_default_mail').val();
		var ss_default_email_settings = (jQuery('#ss_default_email_settings').is(":checked"))?1:0;

		var ss_disable_outgoing_emails_settings = (jQuery('#ss_disable_outgoing_emails_settings').is(":checked"))?1:0;

		var ss_duplicate_post_page = (jQuery('#ss_duplicate_post_page').is(":checked"))?1:0;

        jQuery('textarea[name="custom_functions[]"]').each(function() {
            ss_custom_functions_value.push(jQuery(this).val());
			ss_custom_function_id.push(jQuery(this).data('id'));
        });

		jQuery('input[name="custom_function_switch[]"]').each(function() {
			ss_custom_function_switch_value.push(jQuery(this).is(':checked') ? 1 : 0);
		});


		jQuery.ajax({
			type: 'POST',
			url: ss_toolkit_ajax_url.ajaxurl, // Replace with your AJAX handler URL
			data:{
				'action' : 'ss_toolkit_ajax_request',
				'ss_login': ss_login, 
				'ss_dashboardwidget': ss_dashboardwidget, 
				'ss_shortcode': ss_shortcode, 
				'sstoolkit_removal': sstoolkit_removal, 
				'spotlight_access': spotlight_access, 
				'ss_api_key' : ss_api_key,
				'ss_rss_feed_link' :ss_rss_feed_link,
				'ss_rss_feed_link_promotion' :ss_rss_feed_link_promotion,
				'ss_background_image' :ss_background_image,
				'ss_head_foot_content' :ss_head_foot_content,
				'ss_custom_functions' :ss_custom_functions,
				'ss_custom_functions_value' : ss_custom_functions_value,
				'ss_custom_function_switch_value' : ss_custom_function_switch_value,
				'ss_custom_function_id' : ss_custom_function_id,
				'ss_footer_content' : ss_footer_content,
				'ss_header_content' : ss_header_content,
				'ss_default_email_settings' : ss_default_email_settings,
				'ss_default_mail' : ss_default_mail,
				'ss_disable_outgoing_emails_settings' : ss_disable_outgoing_emails_settings,
				'ss_duplicate_post_page' : ss_duplicate_post_page,
				'ss_google_map_api' : ss_google_map_api,
				'from_toolkit_form' : from_toolkit_form
			},
			success: function(response) {
				jQuery('.ss_toolkit_message').text(response.data.message).css('display','block');
				setTimeout(function() {
					jQuery('.ss_toolkit_message').css('display','none');
				}, 4000);
			},
			error: function(xhr, textStatus, errorThrown) {
				jQuery('.ss_toolkit_message').text("Something went worng").css('display','block');
				setTimeout(function() {
					jQuery('.ss_toolkit_message').css('display','none');
				}, 4000);
			}
		});
	}

});

// Jquery for adding multiple textarea for custom functions
jQuery(document).ready(function($) {
    var maxTextareaCount = 10;
    var textareaWrapper = $('#textarea-wrapper');
    var addButton = $('#add-textarea');
    // var textareaCount = $('.textarea-group').length;

	function createNewTextareaGroup(textareaCount) {
        // textareaCount++;

		var newTextarea = $('<div class="textarea-group" id="textarea_'+ textareaCount +'_Wrapper">');
		newTextarea.append('<div class="textarea-container">');
		newTextarea.find('.textarea-container').append('<label class="uk-form-label" for="custom_function_' + textareaCount + '"><b>Custom Function #' + textareaCount + '</b></label>');
		newTextarea.find('.textarea-container').append('<label class="uk-switch" for="custom-function-switch"><input type="checkbox" id="custom_function_switch_' + textareaCount + '" class="custom-function-switch" name="custom_function_switch[]" checked><span class="uk-switch-slider"></span></label>');
		newTextarea.find('.textarea-container').append('<button type="button" class="remove-custom-function" data-id="'+ textareaCount +'">-</button>');
		newTextarea.find('.textarea-container').append('<textarea class="uk-textarea" id="custom_function_' + textareaCount + '" name="custom_functions[]" data-id="'+ textareaCount +'" cols="30" rows="6" placeholder="' + getCustomText(textareaCount) + '"></textarea>');
		newTextarea.append('</div>');
		newTextarea.append('</div>');
		newTextarea.append('<p></p>');

		textareaWrapper.append(newTextarea);
    }

	function getCustomText(textareaCount) {
        // Customize this function to provide the desired text for the textareas
        return 'Custom Function #' + textareaCount;
    }

    addButton.click(function(event) {
        event.preventDefault();

        var currentCount = textareaWrapper.find('.textarea-group').length;
		console.log(currentCount);
        if (currentCount < maxTextareaCount) {
            var newTextareaGroup = createNewTextareaGroup(currentCount + 1);
            textareaWrapper.append(newTextareaGroup);

            // Focus on the newly added textarea
            textareaWrapper.find('textarea').focus();
        }
    });

	// Event delegation to handle switch state changes
	textareaWrapper.on('change', '.custom-function-switch input', function() {
		var textarea = $(this).siblings('textarea');
		textarea.prop('disabled', !this.checked);
	});
});

jQuery(document).on('click', '.remove-custom-function', function() {
	var id = jQuery(this).data('id');
	jQuery('#textarea_' + id + '_Wrapper').remove();
});