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

    // AJAX Function for saving details
	jQuery('body').on('change blur','.ss-form-input', function() {
		ss_toolkit_ajax_call();
	});

	jQuery('body').on('click','.ss-save-btn', function() {

		ss_toolkit_ajax_call();
	});

	function ss_toolkit_ajax_call(){
		jQuery('.ss_toolkit_message').text('Please wait...').css('display','block');

		var from_toolkit_form = jQuery("#from_toolkit_form").val();

		var ss_login = (jQuery('#ss_login').is(":checked"))?1:0;
		var ss_dashboardwidget = (jQuery('#ss_dashboardwidget').is(":checked"))?1:0;
		var ss_shortcode = (jQuery('#ss_shortcode').is(":checked"))?1:0;

		var sstoolkit_removal = (jQuery('#sstoolkit-removal').is(":checked"))?1:0;
		var spotlight_access = (jQuery('#spotlight-access').is(":checked"))?1:0;
		var ss_api_key = jQuery('#ss_api_key').val();

		var ss_rss_feed_link = (jQuery('#ss_rss_feed_link').is(":checked"))?1:0;
		var ss_rss_feed_link_promotion = (jQuery('#ss_rss_feed_link_promotion').is(":checked"))?1:0;
		var ss_background_image = jQuery("#ss-backgroud-image").val();

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