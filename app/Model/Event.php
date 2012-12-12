<?php
App::uses('AppModel', 'Model');
App::uses('HttpSocket', 'Network/Http');
/**
 * Event Model
 *
 */
class Event extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
				'service_provider' => $sp
			)));
			if ($result) {
				$this->id = $result['Event']['id'];
			} else {
				$event['service_provider'] = $sp;
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
				if (preg_match('/start=([0-9])/', $params, $matches)) {
					$start = $matches[1] + 100;
					$params = preg_replace('/start=([0-9])/', "start=$start", $params);
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
		$response = $this->Http->get("$target?", $params);
		$body = $response->body();
		return json_decode($body, true);
	}
}
