<?php
/**
 * ServiceProviderFixture
 *
 */
class ServiceProviderFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
    public $import = array('model' => 'ServiceProvider');

/**
 * Records
 *
 * @var array
 */
    public $records = array(
        array(
            'id' => 1,
            'name' => 'Zusaar',
            'url' => 'http://www.zusaar.com/',
            'api_url' => 'http://www.zusaar.com/api/event/',
        ),
        array(
            'id' => 2,
            'name' => 'Connpass',
            'url' => 'http://connpass.com/',
            'api_url' => 'http://connpass.com/api/v1/event/',
        ),
        array(
            'id' => 3,
            'name' => 'アテンド',
            'url' => 'http://atnd.org/beta',
            'api_url' => 'http://api.atnd.org/events/',
        ),
    );

}
