/*
 * @preserve: Custom JavaScript Logic - Frontend & Backend
 */

;var WPBP_NS = WPBP_NS || {};

(function($, undefined) {

  WPBP_NS.Common = {

    clearObjectCache: function() {

      $.ajax({
		      type: 'GET',
		      url: wpbp_ajax_filter_params.ajax_url,
					dataType: 'json',
		      data: {
	          action: 'clear_object_cache_ajax'
		      },
		      success: function(result)
		      {
            alert( result.success ? _wpbp_plugin_settings['admin_bar_add_clear_cache_success'] : 'Error: ' + result.message );
		      }
		  });

    }

  }

  // Bind event to clear theme cache Admin Bar link
  if( typeof _wpbp_plugin_settings !== 'undefined' && _wpbp_plugin_settings['show_clear_cache_link'] && _wpbp_plugin_settings['admin_bar_add_clear_cache'] ) {
    $( '#wpadminbar' ).waitUntilExists(function() {
      $('#wp-admin-bar-clear_object_cache').on( 'click', function( event ) {
    		event.preventDefault();
    		WPBP_NS.Common.clearObjectCache();
    		return false;
    	});
    });
  }

})( window.jQuery );
