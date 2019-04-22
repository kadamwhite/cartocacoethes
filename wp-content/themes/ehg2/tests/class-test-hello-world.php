<?php
/**
 * Example test case to verify that Unit tests run correctly.
 */
namespace EHG\Tests;

use WP_UnitTestCase;

/**
 * Class Test_Hello_World
 *
 * @group example
 */
class Test_Hello_World extends WP_UnitTestCase {

	/**
	 * Verify that 1 does, in fact, equal 1.
	 */
	function test_integer_equals() {
		$this->assertEquals( 1, 1 );
	}
}
