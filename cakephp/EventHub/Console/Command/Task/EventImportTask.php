<?php
App::uses('AppShell','Console/Command');
App::uses('Event','Model');
App::uses('HttpSocket', 'Network/Http');
App::uses('ApiConvert','Lib');
class EventImportTask extends AppShell {

    //最大で取得する条件は1年後まで
    const MAX_TIME_CONDITION = '+2 month';

    public $uses = ['Event','ServiceProvider'];

    public $_request_params = '';

    public function initialize(){
        parent::initialize();
        $this->StartDate  = new DateTime();
        $this->TargetDate = new DateTime();
    }

/**
 * ◯時間毎に実行
 * 最後に取得したIDを元に新規イベントを取得する
 * 今日以降の開催日付を条件にすべて取得する
 * @return [type] [description]
 */
    public function execute(){
        $service_providers = Hash::extract($this->ServiceProvider->find('all'),'{n}.ServiceProvider');
        foreach ($service_providers as $service_provider) {
            $this->getByServiceFromApi($service_provider);
            $this->reset();
        }
    }
/**
 * 各サービス毎にAPIをリクエストし結果を保存する
 * @param  [type] $service_provider [description]
 * @return [type]          [description]
 */
    public function getByServiceFromApi($service_provider){
        $ApiConvert = new ApiConvert($service_provider);
        //初回パラメータ
        $params = $this->buildParams();
        while (true) {
            $result = $this->requestApi($service_provider['api_url'],$params);
            if(!empty($result)){
                $ApiConvert->setData($result);
                $data = $ApiConvert->prepare();
                $this->saveEvents($data);
                //次の101件以降があれば
                if($this->hasNext($result)){
                    $params = $this->buildParams(false,true);
                }else{
                    //翌月へ
                    $params = $this->buildParams(true);
                }
            }else{
                //最大で取得する日付に達したら終了
                if($this->limitDate()){
                    break;
                }else{
                    //翌月へ
                    $params = $this->buildParams(true);
                }
            }
        }
    }
    public function reset(){
        $y = $this->StartDate->format('Y');
        $m = $this->StartDate->format('m');
        $d = $this->StartDate->format('d');
        $this->TargetDate->setDate($y,$m,$d);
    }
    public function hasNext($result){
        if($result['results_returned'] == 100){
            return true;
        }else{
            return false;
        }
    }
/**
 * 最大
 * @return [type] [description]
 */
    public function limitDate(){
        $start = $this->TargetDate->format('Ym');
        $EndDate = new DateTime($this->StartDate->format('Y-m-1'));
        $EndDate->modify(self::MAX_TIME_CONDITION);
        $max = $EndDate->format('Ym');
        if($start > $max ){
            return true;
        }
        return false;
    }

/**
 * APIをリクエストし結果を返す
 * @param  [type] $api_url [description]
 * @param  array  $params  [description]
 * @return [type]          [description]
 */
    public function requestApi($api_url,$params=array()) {
        $socket   = new HttpSocket();
        $response = $socket->get($api_url, $params);
        $body     = $response->body();
        $result   =  json_decode($body, true);
        if($result['results_returned'] == 0){
            return array();
        }else{
            return $result;
        }
    }

/**
 * 取得パラメーター
 * @param  boolean $next [description]
 * @return [type]        [description]
 */
    public function buildParams($nextMonth=false,$nextPage=false){
        if($nextMonth){
            $this->TargetDate->modify('+1 month');
        }
        $now_month = $this->TargetDate->format('Ym');
        $params    = 'format=json&ym='.$now_month;

        if($nextPage){
            if (preg_match('/start=(\d+)/', $this->_request_params, $matches)) {
                $start = $matches[1] + 100;
                $params .= '&start='.$start;
            } else {
                $params .= '&start=101';
            }
        }
        return $this->_request_params = $params.'&count=100';
    }
/**
 * [saveEvents description]
 * @return [type] [description]
 */
    public function saveEvents(array $data){
        foreach ($data as $key => $value) {
            //既に保存されていれば更新
            $exists = Hash::extract($this->Event->find('first',array(
                'conditions'=>array(
                    'service_provider_id' =>$value['service_provider_id'],
                    'event_id'            =>$value['event_id'],
                ),
                'recursive'=>-1
            )),'Event');
            if($exists){
                $value['id'] = $exists['id'];
            }
            $this->Event->save($value);
            $this->Event->create();
        }
    }

}