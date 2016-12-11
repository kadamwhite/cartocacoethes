<?php
/**
 * SVG icons related functions and filters, from "Twenty Seventeen" theme
 */

/**
 * Add SVG definitions to the footer. From twentyseventeen.
 */
function ehg_include_svg_icons() {
  // Define SVG sprite file.
  $svg_icons = get_theme_file_path( '/images/svg-icons.svg' );

  // If it exists, include it.
  if ( file_exists( $svg_icons ) ) {
    require_once( $svg_icons );
  }
}
add_action( 'wp_footer', 'ehg_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function ehg_get_svg( $args = array() ) {
  // Make sure $args are an array.
  if ( empty( $args ) ) {
    return __( 'Please define default parameters in the form of an array.', 'twentyseventeen' );
  }

  // Define an icon.
  if ( false === array_key_exists( 'icon', $args ) ) {
    return __( 'Please define an SVG icon filename.', 'twentyseventeen' );
  }

  // Set defaults.
  $defaults = array(
    'icon'        => '',
    'title'       => '',
    'desc'        => '',
    'aria_hidden' => true, // Hide from screen readers.
    'fallback'    => false,
  );

  // Parse args.
  $args = wp_parse_args( $args, $defaults );

  // Set aria hidden.
  $aria_hidden = '';

  if ( true === $args['aria_hidden'] ) {
    $aria_hidden = ' aria-hidden="true"';
  }

  // Set ARIA.
  $aria_labelledby = '';

  if ( $args['title'] && $args['desc'] ) {
    $aria_labelledby = ' aria-labelledby="title desc"';
  }

  // Begin SVG markup.
  $svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

  // If there is a title, display it.
  if ( $args['title'] ) {
    $svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
  }

  // If there is a description, display it.
  if ( $args['desc'] ) {
    $svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
  }

  // Use absolute path in the Customizer so that icons show up in there.
  if ( is_customize_preview() ) {
    $svg .= '<use xlink:href="' . get_parent_theme_file_uri( '/assets/images/svg-icons.svg#icon-' . esc_html( $args['icon'] ) ) . '"></use>';
  } else {
    $svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
  }

  // Add some markup to use as a fallback for browsers that do not support SVGs.
  if ( $args['fallback'] ) {
    $svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
  }

  $svg .= '</svg>';

  return $svg;
}

/**
 * Add dropdown icon if menu item has children. From twentyseventeen.
 *
 * @param  string $title The menu item's title.
 * @param  object $item  The current menu item.
 * @param  array  $args  An array of wp_nav_menu() arguments.
 * @param  int    $depth Depth of menu item. Used for padding.
 * @return string $title The menu item's title with dropdown icon.
 */
function ehg_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
  if ( 'primary' === $args->theme_location ) {
    foreach ( $item->classes as $value ) {
      if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
        $title = $title . ehg_get_svg( array( 'icon' => 'expand' ) );
      }
    }
  }

  return $title;
}
add_filter( 'nav_menu_item_title', 'ehg_dropdown_icon_to_menu_link', 10, 4 );
