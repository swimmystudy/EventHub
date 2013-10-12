<?php
App::uses('ServiceProvider', 'Model');

/**
 * ServiceProvider Test Case
 *
 */
class ServiceProviderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.service_provider'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ServiceProvider = ClassRegistry::init('ServiceProvider');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ServiceProvider);

		parent::tearDown();
	}

}
