<?php
class GreetingsController extends AppController {
	public $helpers = array('Html', 'Form');
	
	var $paginate = array(
		'Greeting' => array(
			'limit' => 1,
		)
	);

	public function index() {
		$this->loadModel('Greeting');
		$data = $this->paginate('Greeting');
		$this->set('Greeting',$data);
	}
	
	public function sendmessage() {
		$message = $_POST["message"];
		if($message != ""){	
			$this->loadModel('Greeting');
			$last_insert_id = $this->Greeting->setData($message);
			$this->redirect("/greetings/result/".$last_insert_id."/");
		} else {
			$this->redirect("/greetings/nomessage/");
		}
	}
	
	public function result($message_id = null) {
		$this->loadModel('Greeting');
		$greeting = $this->Greeting->getBody($message_id);
		$message  = $this->_getMessage($greeting);
		$this->set('message',$message);
	}

	public function nomessage($id = null) {
		$message = "";
		$message = "sorry";
		$this->set('message',$message);
	}

	private function _getMessage($keyword){
		$message = $this->_sendApi($keyword);

var_dump($message);

		if( preg_match("/arbeit/",$message,$matches) ){
			$message = "Let's go arbeit!";
		} else {
			$message = "No";
		}
		return $message; 
	}

	private function _sendApi($keyword){
		$url = "http://jlp.yahooapis.jp/MAService/V1/parse";
		$appid = "dj0zaiZpPUFTSFVWZWtnSHZDcCZzPWNvbnN1bWVyc2VjcmV0Jng9N2E-";
		$sentence = $keyword;
		$other = "&results=ma,uniq&uniq_filter=9%7C10";
		$request = $url . "?" . "appid=" . $appid . "&" . "sentence=" . $keyword . $other;
		$result = file_get_contents($request);
		return $result;
	}


}
?>
