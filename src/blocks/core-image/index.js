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
		namespace: `ehg/${ name }`,
		callback: createHigherOrderComponent( BlockEdit => compose(
			withSelect( select => ( {
				featuredMediaId: select( 'core/editor' ).getEditedPostAttribute( 'featured_media' ),
			} ) ),
			withDispatch( dispatch => ( {
				setFeaturedMediaId: id => dispatch( 'core/editor' ).editPost( {
					featured_media: id,
				} ),
			} ) ),
		)( ( {
			featuredMediaId,
			setFeaturedMediaId,
			...props
		} ) => {
			// Only add toolbar to core/image block.
			if ( props.name !== 'core/image' ) {
				return (
					<BlockEdit { ...props } />
				);
			}

			const isFeaturedImage = props.attributes.id === featuredMediaId;

			return (
				<Fragment>
					<BlockEdit { ...props } />
					<BlockControls>
						<Toolbar controls={ [
							{
								icon: isFeaturedImage ? 'star-filled' : 'star-empty',
								title: __( 'Feature this image', 'ehg' ),
								isActive: isFeaturedImage,
								// Set this image as the featured item, or unselect it.
								onClick: () => setFeaturedMediaId( isFeaturedImage ? 0 : props.attributes.id ),
							},
						] } />
					</BlockControls>
				</Fragment>
			);
		} ), 'withFeatureThisImageButton' ),
	},
];
