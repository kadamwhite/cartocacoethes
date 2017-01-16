/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	__webpack_require__( 1 );
	__webpack_require__( 5 );
	__webpack_require__( 6 );


/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	var ehgScreenReaderText = __webpack_require__( 2 );
	var $ = __webpack_require__( 3 );
	var debounce = __webpack_require__( 4 );
	
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
	 * Ensure the main content starts below the navigation header
	 */
	function clearContentBelowNav() {
	  navigationHeight = $navigation.height();
	  $( '#page' ).css( 'padding-top', navigationHeight + 'px' );
	}
	
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
	  clearContentBelowNav();
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
	
	var $titles = $( '.featured-category-title' );
	function adjustHomepageCategoryTitles() {
	  if (!$titles.length) {
	    return;
	  }
	  $titles.find( 'br' ).remove();
	  var range = $titles.get().reduce(function(minmax, titleNode) {
	    var $title = $( titleNode );
	    var titleHeight = $title.height();
	    return {
	      max: Math.max(minmax.max, titleHeight),
	      min: Math.min(minmax.min, titleHeight)
	    };
	  }, {
	    min: Infinity,
	    max: -Infinity
	  });
	  if (range.min !== range.max) {
	    $titles.each(function( idx, titleNode ) {
	      var $title = $( titleNode );
	      var titleHeight = $title.height();
	      if ( titleHeight < range.max ) {
	        $title.html( $title.html() + '<br>&nbsp;' );
	      }
	    });
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
	    adjustHomepageCategoryTitles();
	  }
	
	  supportsInlineSVG();
	  if ( true === supportsInlineSVG() ) {
	    document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
	  }
	} );
	
	if ( $body.find( '.main-navigation' ).length ) {
	
	  // On scroll, we want to stick/unstick the navigation
	  // debounce to 60fps
	  $( window ).on( 'scroll', debounce( function() {
	    adjustScrollClass();
	  }, 17 ) );
	
	  // Also want to make sure the navigation is where it should be on resize
	  // debounce to 60fps
	  $( window ).resize( debounce( function() {
	    setNavProps();
	    adjustHomepageCategoryTitles();
	    setTimeout( adjustScrollClass, 500 );
	  }, 17 ) );
	}
	
	/**
	 * Toggle display visibility of copyright information in footer
	 */
	var $copyright = $( '.copyright-more-info' );
	var $copyrightToggle = $( '#copyright-more-info-toggle' );
	$copyrightToggle.on( 'click', function( e ) {
	  $copyright.toggleClass( 'assistive-text' );
	  if ( $copyright.hasClass('assistive-text') ) {
	    $copyrightToggle.attr( 'href', '#' );
	  } else {
	    $copyrightToggle.attr( 'href', '#copyright-notice' );
	  }
	});
	
	/**
	 * Toggle visibility of comment threads
	 */
	var $commentsForm = $('#comments');
	$('#comment-toggle').on('click', function( e ) {
	  e.preventDefault();
	  $commentsForm.slideToggle();
	  $(this).find('span').toggle();
	});


/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = ehgScreenReaderText;

/***/ },
/* 3 */
/***/ function(module, exports) {

	module.exports = jQuery;

/***/ },
/* 4 */
/***/ function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/**
	 * lodash (Custom Build) <https://lodash.com/>
	 * Build: `lodash modularize exports="npm" -o ./`
	 * Copyright jQuery Foundation and other contributors <https://jquery.org/>
	 * Released under MIT license <https://lodash.com/license>
	 * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
	 * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
	 */
	
	/** Used as the `TypeError` message for "Functions" methods. */
	var FUNC_ERROR_TEXT = 'Expected a function';
	
	/** Used as references for various `Number` constants. */
	var NAN = 0 / 0;
	
	/** `Object#toString` result references. */
	var symbolTag = '[object Symbol]';
	
	/** Used to match leading and trailing whitespace. */
	var reTrim = /^\s+|\s+$/g;
	
	/** Used to detect bad signed hexadecimal string values. */
	var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;
	
	/** Used to detect binary string values. */
	var reIsBinary = /^0b[01]+$/i;
	
	/** Used to detect octal string values. */
	var reIsOctal = /^0o[0-7]+$/i;
	
	/** Built-in method references without a dependency on `root`. */
	var freeParseInt = parseInt;
	
	/** Detect free variable `global` from Node.js. */
	var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;
	
	/** Detect free variable `self`. */
	var freeSelf = typeof self == 'object' && self && self.Object === Object && self;
	
	/** Used as a reference to the global object. */
	var root = freeGlobal || freeSelf || Function('return this')();
	
	/** Used for built-in method references. */
	var objectProto = Object.prototype;
	
	/**
	 * Used to resolve the
	 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
	 * of values.
	 */
	var objectToString = objectProto.toString;
	
	/* Built-in method references for those with the same name as other `lodash` methods. */
	var nativeMax = Math.max,
	    nativeMin = Math.min;
	
	/**
	 * Gets the timestamp of the number of milliseconds that have elapsed since
	 * the Unix epoch (1 January 1970 00:00:00 UTC).
	 *
	 * @static
	 * @memberOf _
	 * @since 2.4.0
	 * @category Date
	 * @returns {number} Returns the timestamp.
	 * @example
	 *
	 * _.defer(function(stamp) {
	 *   console.log(_.now() - stamp);
	 * }, _.now());
	 * // => Logs the number of milliseconds it took for the deferred invocation.
	 */
	var now = function() {
	  return root.Date.now();
	};
	
	/**
	 * Creates a debounced function that delays invoking `func` until after `wait`
	 * milliseconds have elapsed since the last time the debounced function was
	 * invoked. The debounced function comes with a `cancel` method to cancel
	 * delayed `func` invocations and a `flush` method to immediately invoke them.
	 * Provide `options` to indicate whether `func` should be invoked on the
	 * leading and/or trailing edge of the `wait` timeout. The `func` is invoked
	 * with the last arguments provided to the debounced function. Subsequent
	 * calls to the debounced function return the result of the last `func`
	 * invocation.
	 *
	 * **Note:** If `leading` and `trailing` options are `true`, `func` is
	 * invoked on the trailing edge of the timeout only if the debounced function
	 * is invoked more than once during the `wait` timeout.
	 *
	 * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
	 * until to the next tick, similar to `setTimeout` with a timeout of `0`.
	 *
	 * See [David Corbacho's article](https://css-tricks.com/debouncing-throttling-explained-examples/)
	 * for details over the differences between `_.debounce` and `_.throttle`.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Function
	 * @param {Function} func The function to debounce.
	 * @param {number} [wait=0] The number of milliseconds to delay.
	 * @param {Object} [options={}] The options object.
	 * @param {boolean} [options.leading=false]
	 *  Specify invoking on the leading edge of the timeout.
	 * @param {number} [options.maxWait]
	 *  The maximum time `func` is allowed to be delayed before it's invoked.
	 * @param {boolean} [options.trailing=true]
	 *  Specify invoking on the trailing edge of the timeout.
	 * @returns {Function} Returns the new debounced function.
	 * @example
	 *
	 * // Avoid costly calculations while the window size is in flux.
	 * jQuery(window).on('resize', _.debounce(calculateLayout, 150));
	 *
	 * // Invoke `sendMail` when clicked, debouncing subsequent calls.
	 * jQuery(element).on('click', _.debounce(sendMail, 300, {
	 *   'leading': true,
	 *   'trailing': false
	 * }));
	 *
	 * // Ensure `batchLog` is invoked once after 1 second of debounced calls.
	 * var debounced = _.debounce(batchLog, 250, { 'maxWait': 1000 });
	 * var source = new EventSource('/stream');
	 * jQuery(source).on('message', debounced);
	 *
	 * // Cancel the trailing debounced invocation.
	 * jQuery(window).on('popstate', debounced.cancel);
	 */
	function debounce(func, wait, options) {
	  var lastArgs,
	      lastThis,
	      maxWait,
	      result,
	      timerId,
	      lastCallTime,
	      lastInvokeTime = 0,
	      leading = false,
	      maxing = false,
	      trailing = true;
	
	  if (typeof func != 'function') {
	    throw new TypeError(FUNC_ERROR_TEXT);
	  }
	  wait = toNumber(wait) || 0;
	  if (isObject(options)) {
	    leading = !!options.leading;
	    maxing = 'maxWait' in options;
	    maxWait = maxing ? nativeMax(toNumber(options.maxWait) || 0, wait) : maxWait;
	    trailing = 'trailing' in options ? !!options.trailing : trailing;
	  }
	
	  function invokeFunc(time) {
	    var args = lastArgs,
	        thisArg = lastThis;
	
	    lastArgs = lastThis = undefined;
	    lastInvokeTime = time;
	    result = func.apply(thisArg, args);
	    return result;
	  }
	
	  function leadingEdge(time) {
	    // Reset any `maxWait` timer.
	    lastInvokeTime = time;
	    // Start the timer for the trailing edge.
	    timerId = setTimeout(timerExpired, wait);
	    // Invoke the leading edge.
	    return leading ? invokeFunc(time) : result;
	  }
	
	  function remainingWait(time) {
	    var timeSinceLastCall = time - lastCallTime,
	        timeSinceLastInvoke = time - lastInvokeTime,
	        result = wait - timeSinceLastCall;
	
	    return maxing ? nativeMin(result, maxWait - timeSinceLastInvoke) : result;
	  }
	
	  function shouldInvoke(time) {
	    var timeSinceLastCall = time - lastCallTime,
	        timeSinceLastInvoke = time - lastInvokeTime;
	
	    // Either this is the first call, activity has stopped and we're at the
	    // trailing edge, the system time has gone backwards and we're treating
	    // it as the trailing edge, or we've hit the `maxWait` limit.
	    return (lastCallTime === undefined || (timeSinceLastCall >= wait) ||
	      (timeSinceLastCall < 0) || (maxing && timeSinceLastInvoke >= maxWait));
	  }
	
	  function timerExpired() {
	    var time = now();
	    if (shouldInvoke(time)) {
	      return trailingEdge(time);
	    }
	    // Restart the timer.
	    timerId = setTimeout(timerExpired, remainingWait(time));
	  }
	
	  function trailingEdge(time) {
	    timerId = undefined;
	
	    // Only invoke if we have `lastArgs` which means `func` has been
	    // debounced at least once.
	    if (trailing && lastArgs) {
	      return invokeFunc(time);
	    }
	    lastArgs = lastThis = undefined;
	    return result;
	  }
	
	  function cancel() {
	    if (timerId !== undefined) {
	      clearTimeout(timerId);
	    }
	    lastInvokeTime = 0;
	    lastArgs = lastCallTime = lastThis = timerId = undefined;
	  }
	
	  function flush() {
	    return timerId === undefined ? result : trailingEdge(now());
	  }
	
	  function debounced() {
	    var time = now(),
	        isInvoking = shouldInvoke(time);
	
	    lastArgs = arguments;
	    lastThis = this;
	    lastCallTime = time;
	
	    if (isInvoking) {
	      if (timerId === undefined) {
	        return leadingEdge(lastCallTime);
	      }
	      if (maxing) {
	        // Handle invocations in a tight loop.
	        timerId = setTimeout(timerExpired, wait);
	        return invokeFunc(lastCallTime);
	      }
	    }
	    if (timerId === undefined) {
	      timerId = setTimeout(timerExpired, wait);
	    }
	    return result;
	  }
	  debounced.cancel = cancel;
	  debounced.flush = flush;
	  return debounced;
	}
	
	/**
	 * Checks if `value` is the
	 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
	 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
	 * @example
	 *
	 * _.isObject({});
	 * // => true
	 *
	 * _.isObject([1, 2, 3]);
	 * // => true
	 *
	 * _.isObject(_.noop);
	 * // => true
	 *
	 * _.isObject(null);
	 * // => false
	 */
	function isObject(value) {
	  var type = typeof value;
	  return !!value && (type == 'object' || type == 'function');
	}
	
	/**
	 * Checks if `value` is object-like. A value is object-like if it's not `null`
	 * and has a `typeof` result of "object".
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
	 * @example
	 *
	 * _.isObjectLike({});
	 * // => true
	 *
	 * _.isObjectLike([1, 2, 3]);
	 * // => true
	 *
	 * _.isObjectLike(_.noop);
	 * // => false
	 *
	 * _.isObjectLike(null);
	 * // => false
	 */
	function isObjectLike(value) {
	  return !!value && typeof value == 'object';
	}
	
	/**
	 * Checks if `value` is classified as a `Symbol` primitive or object.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
	 * @example
	 *
	 * _.isSymbol(Symbol.iterator);
	 * // => true
	 *
	 * _.isSymbol('abc');
	 * // => false
	 */
	function isSymbol(value) {
	  return typeof value == 'symbol' ||
	    (isObjectLike(value) && objectToString.call(value) == symbolTag);
	}
	
	/**
	 * Converts `value` to a number.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to process.
	 * @returns {number} Returns the number.
	 * @example
	 *
	 * _.toNumber(3.2);
	 * // => 3.2
	 *
	 * _.toNumber(Number.MIN_VALUE);
	 * // => 5e-324
	 *
	 * _.toNumber(Infinity);
	 * // => Infinity
	 *
	 * _.toNumber('3.2');
	 * // => 3.2
	 */
	function toNumber(value) {
	  if (typeof value == 'number') {
	    return value;
	  }
	  if (isSymbol(value)) {
	    return NAN;
	  }
	  if (isObject(value)) {
	    var other = typeof value.valueOf == 'function' ? value.valueOf() : value;
	    value = isObject(other) ? (other + '') : other;
	  }
	  if (typeof value != 'string') {
	    return value === 0 ? value : +value;
	  }
	  value = value.replace(reTrim, '');
	  var isBinary = reIsBinary.test(value);
	  return (isBinary || reIsOctal.test(value))
	    ? freeParseInt(value.slice(2), isBinary ? 2 : 8)
	    : (reIsBadHex.test(value) ? NAN : +value);
	}
	
	module.exports = debounce;
	
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ },
/* 5 */
/***/ function(module, exports, __webpack_require__) {

	var ehgScreenReaderText = __webpack_require__( 2 );
	var $ = __webpack_require__( 3 );
	
	/**
	 * Theme functions file.
	 *
	 * Contains handlers for navigation and widget area.
	 */
	var mainNavigation = $( '.main-navigation' );
	var masthead;
	var menuToggle;
	var siteNavigation;
	
	if (mainNavigation.length) {
		function initMainNavigation( container ) {
			// Add dropdown toggle that displays child menu items.
			var dropdownToggle = $( '<button />', {
				'class': 'dropdown-toggle',
				'aria-expanded': false
			} ).append( ehgScreenReaderText.icon )
			.append( $( '<span />', {
				'class': 'screen-reader-text',
				text: ehgScreenReaderText.expand
			} ) );
	
			container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );
	
			// Toggle buttons and submenu items with active children menu items.
			container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
			container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );
	
			// Add menu items with submenus to aria-haspopup="true".
			container.find( '.menu-item-has-children, .page_item_has_children' ).attr( 'aria-haspopup', 'true' );
	
			container.find( '.dropdown-toggle' ).click( function( e ) {
				var _this            = $( this ),
					screenReaderSpan = _this.find( '.screen-reader-text' );
	
				e.preventDefault();
				_this.toggleClass( 'toggled-on' );
				_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
	
				// jscs:disable
				_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
				// jscs:enable
				screenReaderSpan.text(
					screenReaderSpan.text() === ehgScreenReaderText.expand ?
						ehgScreenReaderText.collapse :
						ehgScreenReaderText.expand
				);
			} );
		}
		initMainNavigation( mainNavigation );
	
		masthead         = $( '#masthead' );
		menuToggle       = masthead.find( '.menu-toggle' );
		siteNavigation   = masthead.find( '.main-navigation > div > ul' );
	
		// Enable menuToggle.
		( function() {
	
			// Return early if menuToggle is missing.
			if ( ! menuToggle.length ) {
				return;
			}
	
			// Add an initial values for the attribute.
			menuToggle.add( siteNavigation ).attr( 'aria-expanded', 'false' );
	
			menuToggle.on( 'click.twentyseventeen', function() {
				$( siteNavigation.closest( '.main-navigation' ), this ).toggleClass( 'toggled-on' );
	
				// jscs:disable
				$( this )
					.add( siteNavigation )
					.attr( 'aria-expanded', $( this ).add( siteNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
				// jscs:enable
			} );
		} )();
	
		// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
		( function() {
			if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
				return;
			}
	
			// Toggle `focus` class to allow submenu access on tablets.
			function toggleFocusClassTouchScreen() {
				if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {
	
					$( document.body ).on( 'touchstart.twentyseventeen', function( e ) {
						if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
							$( '.main-navigation li' ).removeClass( 'focus' );
						}
					} );
	
					siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).on( 'touchstart.twentyseventeen', function( e ) {
						var el = $( this ).parent( 'li' );
	
						if ( ! el.hasClass( 'focus' ) ) {
							e.preventDefault();
							el.toggleClass( 'focus' );
							el.siblings( '.focus' ).removeClass( 'focus' );
						}
					} );
	
				} else {
					siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.twentyseventeen' );
				}
			}
	
			if ( 'ontouchstart' in window ) {
				$( window ).on( 'resize.twentyseventeen', toggleFocusClassTouchScreen );
				toggleFocusClassTouchScreen();
			}
	
			siteNavigation.find( 'a' ).on( 'focus.twentyseventeen blur.twentyseventeen', function() {
				$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
			} );
		} )();
	
		// Add the default ARIA attributes for the menu toggle and the navigations.
		function onResizeARIA() {
			if ( 'block' === $( '.menu-toggle' ).css( 'display' ) ) {
	
				if ( menuToggle.hasClass( 'toggled-on' ) ) {
					menuToggle.attr( 'aria-expanded', 'true' );
				} else {
					menuToggle.attr( 'aria-expanded', 'false' );
				}
	
				if ( siteNavigation.closest( '.main-navigation' ).hasClass( 'toggled-on' ) ) {
					siteNavigation.attr( 'aria-expanded', 'true' );
				} else {
					siteNavigation.attr( 'aria-expanded', 'false' );
				}
			} else {
				menuToggle.removeAttr( 'aria-expanded' );
				siteNavigation.removeAttr( 'aria-expanded' );
				menuToggle.removeAttr( 'aria-controls' );
			}
		}
	
		$( document ).ready( function() {
			$( window ).on( 'load.twentyseventeen', onResizeARIA );
			$( window ).on( 'resize.twentyseventeen', onResizeARIA );
		} );
	
	}


/***/ },
/* 6 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ }
/******/ ]);
//# sourceMappingURL=theme.js.map