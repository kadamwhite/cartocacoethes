/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( () => {
	const container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	const button = container.getElementsByTagName( 'button' )[0];
	if ( button === undefined ) {
		return;
	}

	const menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( menu === undefined ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( menu.className.indexOf( 'nav-menu' ) === -1 ) {
		menu.className += ' nav-menu';
	}

	button.onclick = () => {
		if ( container.className.indexOf( 'toggled' ) !== -1 ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName( 'a' );

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		let self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( self.className.indexOf( 'nav-menu' ) === -1 ) {

			// On li elements toggle the class .focus.
			if ( self.tagName.toLowerCase() === 'li' ) {
				if ( self.className.indexOf( 'focus' ) !== -1 ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( let i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	const parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	function touchStartFn( e ) {
		const menuItem = this.parentNode;

		if ( ! menuItem.classList.contains( 'focus' ) ) {
			e.preventDefault();
			for ( let i = 0; i < menuItem.parentNode.children.length; ++i ) {
				if ( menuItem === menuItem.parentNode.children[i] ) {
					continue;
				}
				menuItem.parentNode.children[i].classList.remove( 'focus' );
			}
			menuItem.classList.add( 'focus' );
		} else {
			menuItem.classList.remove( 'focus' );
		}
	}

	if ( 'ontouchstart' in window ) {
		for ( let i = 0; i < parentLink.length; ++i ) {
			parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
		}
	}
} )();
