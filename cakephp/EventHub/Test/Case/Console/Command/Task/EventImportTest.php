<?php
App::uses('EventImportTask', 'Console/Command/Task');
App::uses('Event', 'Model');
App::uses('ServiceProvider','Model');
/**
 * Event Test Case
 *
 */
class EventImportTaskTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
    public $fixtures = array(
        'app.event',
        'app.service_provider',
    );

/**
 * setUp method
 *
 * @return void
 */
    public function setUp() {
        parent::setUp();
        $out = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $in  = $this->getMock('ConsoleInput', array(), array(), '', false);
        $this->Task = new EventImportTask($out, $out, $in);
        $this->Task->initialize();
    }
/**
 * tearDown method
 *
 * @return void
 */
    public function tearDown() {
        unset($this->Task);
        parent::tearDown();
    }
/**
 * @test
 *
 */
    public function 取り込みのテスト(){
        $Event = $this->getMockForModel('Event', array('send'));
        $Event->expects($this->once())
        ->method('send')
        ->will($this->returnValue(true));
        var_dump($Event);exit;

        $this->Task->execute();
    }

}
