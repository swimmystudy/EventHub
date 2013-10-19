<?php
/**
 * EventFixture
 *
 */
class EventFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
    public $import = array('model' => 'Event');


/**
 * Records
 *
 * @var array
 */
    public $records = array(
        array(
            'id' => 1,
            'service_provider_id' => 1,
            'event_id' => '1111',
            'title' => 'テストイベント1',
            'description' => 'テストイベント1の説明',
            'event_url' => 'http://demo/1111',
            'started_at' => '2013-10-19 15:20:52',
            'ended_at' => '2013-10-19 15:20:52',
            'place' => '福岡県福岡市',
            'created' => '2013-10-19 15:20:52',
            'modified' => '2013-10-19 15:20:52'
        ),
        array(
            'id' => 2,
            'service_provider_id' => 1,
            'event_id' => '1112',
            'title' => 'テストイベント2',
            'description' => 'テストイベント2の説明',
            'event_url' => 'http://demo/1112',
            'started_at' => '2013-11-19 15:20:52',
            'ended_at' => '2013-11-19 15:20:52',
            'place' => '福岡県福岡市',
            'created' => '2013-10-19 15:20:52',
            'modified' => '2013-10-19 15:20:52'
        ),
        array(
            'id' => 3,
            'service_provider_id' => 2,
            'event_id' => '292929',
            'title' => 'テストイベント',
            'description' => 'テストイベント3の説明',
            'event_url' => 'http://demo2/292929',
            'started_at' => '2013-10-19 15:20:52',
            'ended_at' => '2013-10-19 15:20:52',
            'place' => '福岡県福岡市',
            'created' => '2013-10-19 15:20:52',
            'modified' => '2013-10-19 15:20:52'
        ),
        array(
            'id' => 4,
            'service_provider_id' => 2,
            'event_id' => '292930',
            'title' => 'テストイベント',
            'description' => 'テストイベント3の説明',
            'event_url' => 'http://demo2/292930',
            'started_at' => '2013-11-19 15:20:52',
            'ended_at' => '2013-11-19 15:20:52',
            'place' => '福岡県福岡市',
            'created' => '2013-10-19 15:20:52',
            'modified' => '2013-10-19 15:20:52'
        ),
    );

}
