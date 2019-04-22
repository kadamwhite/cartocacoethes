import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/editor';
import { compose, createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { Toolbar } from '@wordpress/components';
import { withDispatch, withSelect } from '@wordpress/data';

export const name = 'core/image';

export const filters = [
	/**
	 * Add a toolbar button to images which will set that image as the featured image.
	 */
	{
		hook: 'editor.BlockEdit',
		namespace: `ehg2/${ name }`,
		callback: createHigherOrderComponent( BlockEdit => compose(
			withSelect( select => ( {
				selectedBlock: select( 'core/editor' ).getSelectedBlock(),
				featuredMediaId: select( 'core/editor' ).getEditedPostAttribute( 'featured_media' ),
			} ) ),
			withDispatch( dispatch => ( {
				setFeaturedMediaId: id => dispatch( 'core/editor' ).editPost( {
					featured_media: id,
				} ),
			} ) ),
		)( props => {
			if ( props.name !== 'core/image' ) {
				return (
					<BlockEdit { ...props } />
				);
			}
			return (
				<Fragment>
					<BlockEdit { ...props } />
					<BlockControls>
						<Toolbar controls={ [
							{
								icon: props.attributes.id === props.featuredMediaId ?
									'star-filled' :
									'star-empty',
								title: __( 'Feature this image', 'ehg2' ),
								isActive: props.attributes.id === props.featuredMediaId,
								onClick: ( ...args ) => {
									// Set this image as the featured item, or unselect it.
									if ( props.attributes.id !== props.featuredMediaId ) {
										props.setFeaturedMediaId( props.attributes.id );
									} else {
										props.setFeaturedMediaId( 0 );
									}
								},
							},
						] } />
					</BlockControls>
				</Fragment>
			);
		} ), 'withFeatureThisImageButton' ),
	},
];
