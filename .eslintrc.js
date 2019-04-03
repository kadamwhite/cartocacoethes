// Ported from eslint-config-humanmade; can update to 0.6.0 once released
module.exports = {
	'extends': [
		'humanmade',
	],
	'rules': {
		'react/react-in-jsx-scope': [ 'off' ],
		'space-before-function-paren': [ 'error', {
			'anonymous': 'never',
			'named': 'never',
			'asyncArrow': 'always',
		} ],
	},
	'globals': {
		'wp': true,
	},
};
