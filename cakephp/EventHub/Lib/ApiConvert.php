<?php
/**
 * イベント毎のAPI結果をEventModelにマッピングする
 */
class ApiConvert{

    protected $provider_id;

    protected $name;

    protected $url;

    protected $api_url;

    protected $data;


    public function __construct($service_provider){
        if(array_key_exists('ServiceProvider',$service_provider)){
            $service_provider = $service_provider['ServiceProvider'];
        }
        $this->provider_id = $service_provider['id'];
        $this->name        = $service_provider['name'];
        $this->url         = $service_provider['url'];
        $this->api_url     = $service_provider['api_url'];
    }
    public function getData(){
        return $this->data;
    }
    public function setData($data){
        return $this->data = $data;
    }
    public function getType(){
        if($this->api_url == 'http://www.zusaar.com/api/event/'){
            return 'zusaar';
        }
        if($this->api_url == 'http://atnd.org/beta'){
            return 'atnd';
        }
        if($this->api_url == 'http://connpass.com/api/v1/event/'){
            return 'connpass';
        }
        return 'unknown';
    }
/**
 * 整形した配列を返す
 * @return [type] [description]
 */
    public function prepare(){
        if(empty($this->data)) return;
        $type = $this->getType();
        switch ($type) {
            case 'zusaar':
                $data = $this->data['event'];
                break;
            case 'atnd':
            case 'connpass':
                $data = $this->data['events'];
                break;
            default:
                $data = $this->data['events'];
                break;
        }
        $return = array();
        $map_method = 'map_'.$type;
        if(method_exists($this,$map_method)){
            foreach ($data as $key => $value) {
                $return[] = $this->{$map_method}($value);
            }
        }
        return $return;
    }
/**
 * [zusser description]
 * @return [type] [description]
 */
    public function map_zusaar($event){
        return array(
            'service_provider_id' =>$this->provider_id,
            'event_id'            =>$event['event_id'],
            'title'               =>$event['title'],
            'description'         =>$event['description'],
            'event_url'           =>$event['event_url'],
            'started_at'          =>$event['started_at'],
            'ended_at'            =>$event['ended_at'],
            'place'               =>$event['address'],
        );
    }
/**
 * [zusser description]
 * @return [type] [description]
 */
    public function map_connpass($event){
        return array(
            'service_provider_id' =>$this->provider_id,
            'event_id'            =>$event['event_id'],
            'title'               =>$event['title'],
            'description'         =>$event['description'],
            'event_url'           =>$event['event_url'],
            'started_at'          =>$event['started_at'],
            'ended_at'            =>$event['ended_at'],
            'place'               =>$event['place'],
        );
    }




}