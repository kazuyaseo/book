<?php
class Response extends AppModel {
	private $table_name = "responses";
	public $validate = array(
		'body' => array( 'rule' => 'notEmpty'),
	);
	
	public function setData($message){
		$last_id = 0;
		$sql = "INSERT INTO ".$this->table_name."(body,created,modified)  VALUES(:message, NOW(), NOW());";
		$params = array('message'=> $message);
		$data = $this->query($sql,$params);
		$sql = "SELECT LAST_INSERT_ID();";
		$data = $this->query($sql);
		$values = $data[0][0];
		$last_insert_id = $values["LAST_INSERT_ID()"];
		return $last_insert_id;
	}

	public function getBody($id){
		$sql = "SELECT body FROM ".$this->table_name." WHERE id = :id;";
		$params = array('id'=> $id);
		$data = $this->query($sql,$params);
		$values = $data[0]["greetings"]["body"];
		return $values;
	}

}
?>
