import { filePath } from './config-utils';

test( 'properly generates a file system theme file path', () => {
	expect( filePath() ).toBe( `${ process.cwd() }/wp-content` );
	expect( filePath( 'themes/ehg' ) ).toBe( `${ process.cwd() }/wp-content/themes/ehg` );
	expect( filePath( 'themes/ehg', 'build' ) ).toBe( `${ process.cwd() }/wp-content/themes/ehg/build` );
} );
