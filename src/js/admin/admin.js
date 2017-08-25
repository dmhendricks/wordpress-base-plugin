/*
 * @preserve: Custom JavaScript Logic - WP Admin
 */

;var WPBP_NS = WPBP_NS || {};

(function($, undefined) {

  WPBP_NS.Admin = {

    exampleFunction: function( name ) {

      name = name || 'world';
      console.log( 'Hello ' + name );

    }

  }

  // Write a message to the debugger console
  WPBP_NS.Admin.exampleFunction( 'James' );

})( window.jQuery );
