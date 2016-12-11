var ehgScreenReaderText = require( 'ehgScreenReaderText' );
var $ = require( 'jquery' );

// Variables and DOM Caching
var $body = $( 'body' );
var $customHeader = $body.find( '.custom-header' );
var $customHeaderImage = $customHeader.find( '.custom-header-image' );
var $navigation = $body.find( '.navigation-top' );
var $navWrap = $navigation.find( '.wrap' );
var $navMenuItem = $navigation.find( '.menu-item' );
var $menuToggle = $navigation.find( '.menu-toggle' );
var $menuScrollDown = $navigation.find( '.menu-scroll-down' );
var $sidebar = $body.find( '#secondary' );
var $entryContent = $body.find( '.entry-content' );
var isFrontPage = $body.hasClass( 'twentyseventeen-front-page' ) || $body.hasClass( 'home blog' );
var navigationFixedClass = 'site-navigation-fixed';
var navigationHeight;
var navigationOuterHeight;
var navPadding;
var navMenuItemHeight;
var idealNavHeight;
var navIsNotTooTall;
var headerOffset;
var menuTop;

/**
 * Sets properties of navigation
 */
function setNavProps() {
  navigationHeight      = $navigation.height();
  navigationOuterHeight = $navigation.outerHeight();
  navPadding            = parseFloat( $navWrap.css( 'padding-top' ) ) * 2;
  navMenuItemHeight     = $navMenuItem.outerHeight() * 2;
  idealNavHeight        = navPadding + navMenuItemHeight;
  navIsNotTooTall       = navigationHeight <= idealNavHeight;
}

/**
 * Makes navigation 'stick'
 */
function adjustScrollClass() {

  // Make sure we're not on a mobile screen
  if ( 'none' === $menuToggle.css( 'display' ) ) {

    // Make sure the nav isn't taller than two rows
    if ( navIsNotTooTall ) {

      // When there's a custom header image, the header offset includes the height of the navigation
      if ( isFrontPage && $customHeaderImage.length ) {
        headerOffset = $customHeader.innerHeight() - navigationOuterHeight;
      } else {
        headerOffset = $customHeader.innerHeight();
      }

      // If the scroll is more than the custom header, set the fixed class
      if ( $( window ).scrollTop() >= headerOffset ) {
        $navigation.addClass( navigationFixedClass );
      } else {
        $navigation.removeClass( navigationFixedClass );
      }

    } else {

      // Remove 'fixed' class if nav is taller than two rows
      $navigation.removeClass( navigationFixedClass );
    }
  }
}

/**
   * Test if inline SVGs are supported.
   * @link https://github.com/Modernizr/Modernizr/
   */
function supportsInlineSVG() {
  var div = document.createElement( 'div' );
  div.innerHTML = '<svg/>';
  return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
}

// Fires on document ready
$( document ).ready( function() {

  // Let's fire some JavaScript!
  if ( $navigation.length ) {

    /**
     * 'Scroll Down' arrow in menu area
     */
    if ( $( 'body' ).hasClass( 'admin-bar' ) ) {
      menuTop = -32;
    }
    if ( $( 'body' ).hasClass( 'blog' ) ) {
      menuTop -= 30; // The div for latest posts has no space above content, add some to account for this
    }
    $menuScrollDown.click( function( e ) {
      e.preventDefault();
      $( window ).scrollTo( '#primary', {
        duration: 600,
        offset: { 'top': menuTop - navigationOuterHeight }
      } );
    } );

    setNavProps();
    adjustScrollClass();
  }

  supportsInlineSVG();
  if ( true === supportsInlineSVG() ) {
    document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
  }
} );

if ( $body.find( '.main-navigation' ).length ) {

  // On scroll, we want to stick/unstick the navigation
  $( window ).on( 'scroll', function() {
    adjustScrollClass();
  } );

  // Also want to make sure the navigation is where it should be on resize
  $( window ).resize( function() {
    setNavProps();
    setTimeout( adjustScrollClass, 500 );
  } );
}
