<?php
App::uses('ApiConvert', 'Lib');
App::uses('Event', 'Model');
App::uses('ServiceProvider','Model');
/**
 * ApiConvert Test Case
 *
 */
class ApiConvertTest extends CakeTestCase {

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
    public function Zusserのテスト(){
        $provider = $this->ServiceProvider->findByName('Zusaar');
        $ApiConvert = new ApiConvert($provider);
        $ApiConvert->setData($this->json_file('zusaar_1'));
        $result = $ApiConvert->prepare();
        $this->assertEquals(2,count($result));
        $this->assertArrayHasKey('service_provider_id',$result[0]);
        $this->assertArrayHasKey('event_id',$result[0]);
        $this->assertArrayHasKey('title',$result[0]);
        $this->assertArrayHasKey('description',$result[0]);
        $this->assertArrayHasKey('event_url',$result[0]);
        $this->assertArrayHasKey('started_at',$result[0]);
        $this->assertArrayHasKey('ended_at',$result[0]);
        $this->assertArrayHasKey('place',$result[0]);
    }
}
