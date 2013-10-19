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

        $EventImportTask = $this->getMock('EventImportTask', array('requestApi'));
        $this->Task = $EventImportTask;
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
 * json
 * @return [type] [description]
 */
    public function json_file($file_name){
        return json_decode(file_get_contents(TESTS.'Fixture'.DS.'json'.DS.$file_name.'.json'),true);
    }

/**
 * @test
 */
    public function 取得パラメータのテスト(){
        $DateTime = $this->Task->Event->_getTime();
        $DateTime->setDate(2012,5,1);
        $result = $this->Task->buildParams();
        $this->assertEquals($result,'format=json&ym=201205&count=100');

        $DateTime->setDate(2013,11,1);
        $result = $this->Task->buildParams();
        $this->assertEquals($result,'format=json&ym=201311&count=100');

        $result = $this->Task->buildParams(true);
        $this->assertEquals($result,'format=json&ym=201312&count=100');

        $result = $this->Task->buildParams(true);
        $this->assertEquals($result,'format=json&ym=201401&count=100');

        $result = $this->Task->buildParams(false,true);
        $this->assertEquals($result,'format=json&ym=201401&start=101&count=100');

        $result = $this->Task->buildParams(false,true);
        $this->assertEquals($result,'format=json&ym=201401&start=201&count=100');

        $result = $this->Task->buildParams(true,true);
        $this->assertEquals($result,'format=json&ym=201402&start=301&count=100');

    }
/**
 * @test
 */
    public function リクエスト取得のテスト(){
        $this->Task->expects($this->any())
        ->method('requestApi')
        ->will(
            $this->onConsecutiveCalls(
                $this->json_file('atend_1'),
                $this->json_file('atend_2')
            )
        );
        $params = $this->Task->buildParams();
        $result = $this->Task->requestApi('http://www.zusaar.com/api/event/',$params);
        var_dump($result);
        $result = $this->Task->requestApi('http://www.zusaar.com/api/event/',$params);
        var_dump($result);exit;
    }

/**
 * @test
 */
    public function サービス毎のデータ取得のテスト(){
        $this->Task->getByServiceFromApi('http://www.zusaar.com/api/event/');
    }
}
