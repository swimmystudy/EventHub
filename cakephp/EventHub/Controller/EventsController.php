<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 */
class EventsController extends AppController {

	public $components = array('Search.Prg' => array(
		'commonProcess' => array(
			'paramType' => 'querystring',
		)
	));

	public $presetVars = array(
		'service_provider_id' => array('type' => 'checkbox', 'empty' => true),
		'keyword' => array('type' => 'value', 'empty' => true),
		'andor' => array('type' => 'value', 'empty' => true),
		'from' => array('type' => 'value', 'empty' => true),
		'to' => array('type' => 'value', 'empty' => true),
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$serviceProviders = $this->Event->ServiceProvider->find('list');
		$this->set('serviceProviders', $serviceProviders);

		if (!empty($this->request->data['Event']['service_provider_id']) and array_diff(array_keys($serviceProviders), $this->request->data['Event']['service_provider_id']) == false) {
			unset($this->request->data['Event']['service_provider_id']);
		}
		$this->Prg->commonProcess();
		$req = $this->request->query;
		if (!empty($this->request->query['keyword'])) {
			$andor = !empty($this->request->query['andor']) ? $this->request->query['andor'] : null;
			$word = $this->Event->multipleKeywords($this->request->query['keyword'], $andor);
			$req = array_merge($req, array("word" => $word));
		}
		$this->paginate = array(
			'conditions' => $this->Event->parseCriteria($req),
			'paramType' => 'querystring',
//			'limit' => 2,
		);
		$this->set('events', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid %s', __('event')));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('event')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('event')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
		$events = $this->Event->Event->find('list');
		$this->set(compact('events'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid %s', __('event')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('event')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('event')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->Event->read(null, $id);
		}
		$events = $this->Event->Event->find('list');
		$this->set(compact('events'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid %s', __('event')));
		}
		if ($this->Event->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('event')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('event')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

/**
 * update method
 *
 * @return void
 */
	public function update() {
		$this->Event->ServiceProvider->displayField = 'api_url';
		$serviceProviders = $this->Event->ServiceProvider->find('list');
		foreach ($serviceProviders as $sp => $url) {
			$this->Event->update($sp, $url);
		}

		// 過去のイベント情報も保持しておく
		//$this->EventCache->delete_old_cache();

		return new CakeResponse(array('body' => true));
	}
}
