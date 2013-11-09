<?php
/**
 *
 */
App::uses('ConsoleOutput','Console');
class AppConsoleOutput extends ConsoleOutput{

/**
 * [close description]
 * @return [type] [description]
 */
    public function close(){
		if(is_resource($this->_output)) {
	        fclose($this->_output);
	        $this->_output = null;
    	}
    }

/**
 * clean up and close handles
 *
 */
    public function __destruct() {
		if(is_resource($this->_output)) {
	        fclose($this->_output);
    	}
    }

}