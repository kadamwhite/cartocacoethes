import { __ } from '@wordpress/i18n';
import { createHigherOrderComponent } from '@wordpress/compose';

export const name = 'core/columns';

export const filters = [
	/**
	 * Permit registering custom block styles for blocks containing InnerBlocks.
	 * See ticket https://github.com/WordPress/gutenberg/issues/9897
	 */
	{
		hook: 'editor.BlockEdit',
		namespace: `ehg2/${ name }`,
		callback: createHigherOrderComponent( BlockEdit => props => {
			if ( props.name === 'core/columns' && props.insertBlocksAfter === undefined ) {
				let columnRatio = 1 / 2;
				const { className } = props.attributes;
				if ( className.indexOf( 'is-style-small-large' ) > -1 ) {
					columnRatio = 3 / 8;
				} else if ( className.indexOf( 'is-style-large-small' ) > -1 ) {
					columnRatio = 5 / 8;
				}
				const sharedProps = {
					y: 1,
					height: 38,
					stroke: 'black',
					strokeWidth: 1,
					fill: 'none',
				};
				return (
					<svg viewBox="0 0 80 40" style={ {
						width: '100%',
						height: '100%',
					} }>
						<rect { ...sharedProps } x="1" width={ columnRatio * 80 - 2 } />
						<rect { ...sharedProps } x={ columnRatio * 80 + 1 } width={ ( 1 - columnRatio ) * 80 - 2 } />
					</svg>
				);
			}
			return (
				<BlockEdit { ...props } />
			);
		}, 'allowStyleVariants' ),
	},
];

export const styles = [
	{
		name: 'default',
		label: __( 'Default' ),
		isDefault: true,
	},
	{
		name: 'large-small',
		label: __( 'Large - Small' ),
	},
	{
		name: 'small-large',
		label: __( 'Small - Large' ),
	},
];
