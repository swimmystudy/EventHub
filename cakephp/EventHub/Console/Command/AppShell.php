<?php
/**
 * AppShell file
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Shell', 'Console');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell {

/**
 * [consolefile description]
 * @return [type] [description]
 */
    public function consolefile(){
        return TMP.get_class($this).'.out';
    }
/**
 * コンソールの出力を戻す
 * @return [type] [description]
 */
    public function resetOutput(){
        if ($this->stdout) {
            unset($this->stdout);
        }
        if ($this->stderr) {
            unset($this->stderr);
        }
        if ($this->stdin) {
            unset($this->stdin);
        }
        unlink($this->consolefile());
        $this->stdout = new ConsoleOutput('php://stdout');
        $this->stderr = new ConsoleOutput('php://stderr');
        $this->stdin  = new ConsoleInput('php://stdin');
    }
}
