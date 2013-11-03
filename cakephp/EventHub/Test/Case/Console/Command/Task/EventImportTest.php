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
        $DateTime = $this->Task->TargetDate;
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
    public function 最後の月の取得テスト(){
        $this->Task->StartDate->setDate(2013,11,1);

        $this->Task->TargetDate->setDate(2013,11,1);
        $this->assertFalse($this->Task->limitDate());

        $this->Task->TargetDate->setDate(2014,11,1);
        $this->assertTrue($this->Task->limitDate());

        $this->Task->TargetDate->setDate(2014,12,1);
        $this->assertTrue($this->Task->limitDate());
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
        $result = $this->Task->requestApi('http://www.zusaar.com/api/event/',$params);
    }
/**
 * @test
 */
    public function サービス毎のループテスト(){
    }


/**
 * @test
 */
    public function 初期化のテスト(){
        $this->Task->StartDate->setDate(2013,9,1);
        $this->Task->TargetDate->setDate(2013,9,1);
        $this->Task->expects($this->any())
        ->method('requestApi')
        ->will(
            $this->onConsecutiveCalls(
                $this->json_file('zusaar_1'),
                $this->json_file('zusaar_2')
            )
        );
        $ServiceProviderModel = ClassRegistry::init('ServiceProvider');
        $service_provider = Hash::extract($ServiceProviderModel->find('first'),'ServiceProvider');
        $this->Task->getByServiceFromApi($service_provider);
        //時間は2ヶ月進んでいる
        $this->assertEquals('201312',$this->Task->TargetDate->format('Ym'));
        //時間がリセットされいている
        $this->Task->reset();
        $this->assertEquals('201309',$this->Task->TargetDate->format('Ym'));

        // $Event = ClassRegistry::init('Event');
        // var_dump($Event->find('count'));exit;

    }
}
