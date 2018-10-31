import { filePath } from '../config-utils';

test( 'properly generates a file system theme file path', () => {
	expect( filePath() ).toBe( `${ process.cwd() }` );
	expect( filePath( 'themes/ehg' ) ).toBe( `${ process.cwd() }/themes/ehg` );
	expect( filePath( 'themes/ehg', 'build' ) ).toBe( `${ process.cwd() }/themes/ehg/build` );
} );
