<?php
App::uses('AppModel', 'Model');
App::uses('HttpSocket', 'Network/Http');
/**
 * Event Model
 *
 */
class Event extends AppModel {

	public $order = array('Event.id DESC');

	public $actsAs = array('Search.Searchable');

	public $filterArgs = array(
		'service_provider_id' => array('type' => 'subquery', 'method' => 'findByServiceProviders', 'field' => 'Event.service_provider_id'),
		'word' => array('type' => 'like', 'field' => array('Event.title', 'Event.description'), 'connectorAnd' => '+', 'connectorOr' => ','),
		'from' => array('type' => 'value', 'field' => 'Event.started_at >='),
		'to' => array('type' => 'value', 'field' => 'Event.started_at <='),
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'service_provider_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'event_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ServiceProvider' => array(
			'className' => 'ServiceProvider',
			'foreignKey' => 'service_provider_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * multipleKeywords method
 *
 * @param string $keyword Input value
 * @param array $option Advanced search and/or
 * @return string Value for the search process
 */
	public function multipleKeywords($keyword, $andor = null) {
		$connector = ($andor === 'or') ? ',' : '+';
		$keyword = preg_replace('/\s+/', $connector, trim(mb_convert_kana($keyword, 's', 'UTF-8')));
		return $keyword;
	}

/**
 * findByServiceProviders method
 *
 * @param array $data Data for a field.
 * @param array $field Info for field.
 * @return string Subquery
 */
	public function findByServiceProviders($data = array(), $field = array()) {
		$this->ServiceProvider->Behaviors->attach('Search.Searchable');
		$query = $this->ServiceProvider->getQuery('all', array(
			'conditions' => array('ServiceProvider.id'  => explode('|', $data[$field['name']])),
			'fields' => array('ServiceProvider.id'),
		));
		return $query;
	}

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->Http = new HttpSocket();
	}

	public function update($sp, $url, $term = 4) {
		if ($term < 0) return true;
		$events = $this->get_events($url, $term);
		foreach ($events as $event) {
			$result = $this->find('first', array('conditions' => array(
				'event_id' => $event['event_id'],
				'service_provider_id' => $sp
			)));
			if ($result) {
				$this->id = $result['Event']['id'];
			} else {
				$event['service_provider_id'] = $sp;
			}
			$this->save(array('Event' => $event));
			$this->create();
		}
		return true;
	}

	public function delete_old_cache($previous_to = 1) {
		$delete_at = date("Y-m-d", strtotime("-$previous_to month"));
		$conditions = array('ended_at <' => $delete_at);
		$this->deleteAll($conditions);

		// TODO サイトから削除されたイベントをデータベースから削除する作業が必要か検討

		return true;
	}

	private function get_events($target, $term) {
		$now_month = date('Ym');
		//$now_month = $this->_datetime->format('Ym');
		$params = "format=json&ym=$now_month";
		for ($i = 1; $i < $term; $i++) {
			$ym = date("Ym", strtotime("$now_month +$i month"));
			$params = $params . ",$ym";
		}
		$params = $params . "&count=100";

		$events = array();
		while (true) {
			$result = $this->request_sp($params, $target);
			if (isset($result['events'])) {
				$events = array_merge($events, $result['events']);
			} elseif ($result['event']) {
				$events = array_merge($events, $result['event']);
			}
			if ($result['results_returned'] == 100) {
				$matches = null;
				if (preg_match('/start=(\d+)/', $params, $matches)) {
					$start = $matches[1] + 100;
					$params = preg_replace('/start=(\d+)/', "start=$start", $params);
				} else {
					$params = $params . '&start=101';
				}
			} else {
				break;
			}
		}

		return $events;
	}

	private function request_sp($params, $target) {
		$response = $this->Http->get($target, $params);
		$body = $response->body();
		return json_decode($body, true);
	}
}
