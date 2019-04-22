import { __ } from '@wordpress/i18n';

export const name = 'core/heading';

export const filters = [
	/**
	 * Permit registering custom block styles for blocks containing InnerBlocks.
	 * See ticket https://github.com/WordPress/gutenberg/issues/9897
	 */
	{
		hook: 'blocks.registerBlockType',
		namespace: `ehg2/${ name }`,
		callback: ( settings, blockName ) => {
			if ( blockName !== name ) {
				return settings;
			}

			return {
				...settings,
				supports: {
					...settings.supports,
					align: [ 'wide', 'full' ],
				},
			};
		},
	},
];

export const styles = [
	{
		name: 'default',
		label: __( 'Default' ),
		isDefault: true,
	},
	{
		name: 'dark',
		label: __( 'Dark' ),
	},
];
