/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
/* global ehgScreenReaderText: false */

const SITENAV = document.querySelector( '.main-navigation' ),
	KEYMAP = {
		TAB: 9,
	};

if ( SITENAV ) {
	// Initiate the menus (script is loaded in footer).
	initMainNavigation();
	initMenuToggle();
}

/**
 * Initiate the main navigation script.
 */
function initMainNavigation() {
	// Get the submenus.
	const SUBMENUS = SITENAV.querySelectorAll( '.menu ul' );

	// No point if no submenus.
	if ( ! SUBMENUS.length ) {
		return;
	}

	// Create the dropdown button.
	const dropdownButton = getDropdownButton();

	SUBMENUS.forEach( function( submenu ) {
		const parentMenuItem = submenu.parentNode;
		let dropdown = parentMenuItem.querySelector( '.dropdown' );

		// If no dropdown, create one.
		if ( ! dropdown ) {

			// Create dropdown.
			dropdown = document.createElement( 'span' );
			dropdown.classList.add( 'dropdown' );

			const dropdownSymbol = document.createElement( 'i' );
			dropdownSymbol.classList.add( 'dropdown-symbol' );
			dropdown.appendChild( dropdownSymbol );

			// Add before submenu.
			submenu.parentNode.insertBefore( dropdown, submenu );

		}

		// Convert dropdown to button.
		const thisDropdownButton = dropdownButton.cloneNode( true );

		// Copy contents of dropdown into button.
		thisDropdownButton.innerHTML = dropdown.innerHTML;

		// Replace dropdown with toggle button.
		dropdown.parentNode.replaceChild( thisDropdownButton, dropdown );

		// Toggle the submenu when we click the dropdown button.
		thisDropdownButton.addEventListener( 'click', function( event ) {
			toggleSubMenu( this.parentNode );
		} );

		// Clean up the toggle if a mouse takes over from keyboard.
		parentMenuItem.addEventListener( 'mouseleave', function( event ) {
			toggleSubMenu( this, false );
		} );

		// When we focus on a menu link, make sure all siblings are closed.
		parentMenuItem.querySelector( 'a' ).addEventListener( 'focus', function( event ) {
			this.parentNode.parentNode.querySelectorAll( 'li.toggled-on' ).forEach( function( item ) {
				toggleSubMenu( item, false );
			} );
		} );

		// Handle keyboard accessibility for traversing menu.
		submenu.addEventListener( 'keydown', function( event ) {

			// These specific selectors help us only select items that are visible.
			const focusSelector = 'ul.toggle-show > li > a, ul.toggle-show > li > button';

			if ( KEYMAP.TAB === event.keyCode ) {
				if ( event.shiftKey ) {

					// Means we're tabbing out of the beginning of the submenu.
					if ( isfirstFocusableElement( this, document.activeElement, focusSelector ) ) {
						toggleSubMenu( this.parentNode, false );
					}
				} else {

					// Means we're tabbing out of the end of the submenu.
					if ( islastFocusableElement( this, document.activeElement, focusSelector ) ) {
						toggleSubMenu( this.parentNode, false );
					}
				}
			}
		} );
	} );

	SITENAV.classList.add( 'has-dropdown-toggle' );

}

/**
 * Initiate the mobile menu toggle button.
 */
function initMenuToggle() {
	const MENUTOGGLE = SITENAV.querySelector( '.menu-toggle' );

	// Return early if MENUTOGGLE is missing.
	if ( ! MENUTOGGLE ) {
		return;
	}

	// Add an initial values for the attribute.
	MENUTOGGLE.setAttribute( 'aria-expanded', 'false' );

	MENUTOGGLE.addEventListener( 'click', function() {
		SITENAV.classList.toggle( 'toggled-on' );
		this.setAttribute( 'aria-expanded', this.getAttribute( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
	}, false );
}

/**
 * Toggle submenus open and closed, and tell screen readers what's going on.
 */
function toggleSubMenu( parentMenuItem, forceToggle ) {
	const toggleButton = parentMenuItem.querySelector( '.dropdown-toggle' ),
		subMenu = parentMenuItem.querySelector( 'ul' );
	let parentMenuItemToggled = parentMenuItem.classList.contains( 'toggled-on' );

	// Will be true if we want to force the toggle on, false if force toggle close.
	if ( undefined !== forceToggle && ( typeof forceToggle ) == 'boolean' ) {
		parentMenuItemToggled = ! forceToggle;
	}

	// Toggle aria-expanded status.
	toggleButton.setAttribute( 'aria-expanded', ( ! parentMenuItemToggled ).toString() );

	/*
	 * Steps to handle during toggle:
	 * - Let the parent menu item know we're toggled on/off.
	 * - Toggle the ARIA label to let screen readers know will expand or collapse.
	 */
	if ( parentMenuItemToggled ) {

		// Toggle "off" the submenu.
		parentMenuItem.classList.remove( 'toggled-on' );
		subMenu.classList.remove( 'toggle-show' );
		toggleButton.setAttribute( 'aria-label', ehgScreenReaderText.expand );

		// Make sure all children are closed.
		parentMenuItem.querySelectorAll( '.toggled-on' ).forEach( function( item ) {
			toggleSubMenu( item, false );
		} );

	} else {

		// Make sure siblings are closed.
		parentMenuItem.parentNode.querySelectorAll( 'li.toggled-on' ).forEach( function( item ) {
			toggleSubMenu( item, false );
		} );

		// Toggle "on" the submenu.
		parentMenuItem.classList.add( 'toggled-on' );
		subMenu.classList.add( 'toggle-show' );
		toggleButton.setAttribute( 'aria-label', ehgScreenReaderText.collapse );

	}
}

/**
 * Returns the dropdown button
 * element needed for the menu.
 */
function getDropdownButton() {
	const dropdownButton = document.createElement( 'button' );
	dropdownButton.classList.add( 'dropdown-toggle' );
	dropdownButton.setAttribute( 'aria-expanded', 'false' );
	dropdownButton.setAttribute( 'aria-label', ehgScreenReaderText.expand );
	return dropdownButton;
}

/**
 * Returns true if element is the
 * first focusable element in the container.
 */
function isfirstFocusableElement( container, element, focusSelector ) {
	const focusableElements = container.querySelectorAll( focusSelector );
	if ( focusableElements.length > 0 ) {
		return element === focusableElements[0];
	}
	return false;
}

/**
 * Returns true if element is the
 * last focusable element in the container.
 */
function islastFocusableElement( container, element, focusSelector ) {
	const focusableElements = container.querySelectorAll( focusSelector );
	if ( focusableElements.length > 0 ) {
		return element === focusableElements[focusableElements.length - 1];
	}
	return false;
}
