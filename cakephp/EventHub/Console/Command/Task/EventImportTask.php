<?php
App::uses('AppShell','Console/Command');
App::uses('Event','Model');
App::uses('HttpSocket', 'Network/Http');
class EventImportTask extends AppShell {

    //最大で取得する条件は1年後まで
    const MAX_TIME_CONDITION = '+1 year';

    public $uses = ['Event','ServiceProvider'];

    public $_request_params = '';

/**
 * ◯時間毎に実行
 * 最後に取得したIDを元に新規イベントを取得する
 * 今日以降の開催日付を条件にすべて取得する
 * @return [type] [description]
 */
    public function execute(){
        $service = $this->ServiceProvider->find('list',['fields'=>['id','api_url']]);
        foreach ($service as $service_id => $api_url) {
            $this->getByServiceFromApi($api_url);
        }
    }
/**
 * 各サービス毎にAPIをリクエストし結果を保存する
 * @param  [type] $api_url [description]
 * @return [type]          [description]
 */
    public function getByServiceFromApi($api_url){
        //初回パラメータ
        $params = $this->buildParams();
        while (true) {
            $result = $this->requestApi($api_url,$params);
            if(!empty($result)){
                $this->saveEvent($result);
                //次の101件以降があれば
                if($this->hasNext($result)){
                    $params = $this->buildParams(false,true);
                }
            }else{
                if($this->limitDate($params)){
                    break;
                }else{
                    //翌月へ
                    $params = $this->buildParams(true);
                }
            }
        }
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
    public function limitDate($params){
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
            $DateTime = $this->Event->_getTime();
            $DateTime->modify('+1 month');
        }
        $now_month = $this->Event->_getTime()->format('Ym');
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



}