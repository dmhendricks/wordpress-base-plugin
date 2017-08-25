/*
 * @preserve: Custom JavaScript Logic - Frontend
 */

;var WPBP_NS = WPBP_NS || {};

(function($, undefined) {

  WPBP_NS.Site = {

    sampleFunction: function( name ) {

      name = name || 'world';
      console.log( 'Hello ' + name + '!' )

    }

  }

  // Write a message to the debugger console
  //WPBP_NS.Site.sampleFunction( 'Darlene' );

})( window.jQuery );
