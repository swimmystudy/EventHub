<?php
App::uses('AppShell','Console/Command');
class EventShell extends AppShell {

    public $tasks = array('EventImport');

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
                    $this->EventImport->execute();
                    break;
           }
            $command = '';
        }
    }
}