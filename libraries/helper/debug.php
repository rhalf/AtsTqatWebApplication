<?php
class Debug {
	private $message = NULL;

	public function showAlert($message) {
		$this->message = $message;
        echo '<script type="text/javascript">';
        echo 'alert("'.
        	'Debugging Mode                        \n'.
        	'======================================\n'. 
        	$this->message .
        	'\n' .
        	'");';
        echo '</script>';
	} 

	public function showEcho($message) {
		$this->message = $message;
        echo  $this->message;
	} 

	public function getMessage() {
		return $this->message;
	}

}

?>