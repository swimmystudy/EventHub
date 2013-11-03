<?php
App::uses('AppShell','Console/Command');
class ProviderShell extends AppShell {

    public $uses = ['ServiceProvider'];

    public function main($command = null) {
        $this->out(__d('cake_console', 'Interactive Import Shell'));
        $this->hr();
        $this->out(__d('cake_console', '[I] インポート'));
        while (true) {
            if (empty($command)) {
                $command = trim($this->in(''));
            }
            switch ($command) {
                case 'I':
                    $this->ServiceProvider();
                    break;
           }
            $command = '';
        }
    }

    public function ServiceProvider(){
        $db = $this->ServiceProvider->getDataSource();
        $db->truncate($this->ServiceProvider->table);
        $save = array(
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
        );
        $this->ServiceProvider->saveMany($save);
    }

}