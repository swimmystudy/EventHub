<?php
/**
 * AllModelTest class
 *
 * This test group will run model class tests
 *
 * @package       Cake.Test.Case
 */
class AllConsoleTest extends PHPUnit_Framework_TestSuite {

/**
 * suite method, defines tests for this suite.
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Console related class tests');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'Console');
		$suite->addTestDirectory(TESTS .'Case'.DS. 'Console/Command');
        $suite->addTestDirectory(TESTS .'Case'.DS. 'Console/Command/Task');
		return $suite;
	}
}