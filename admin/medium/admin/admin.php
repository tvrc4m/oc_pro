<?php

class Admin extends Medium{

	public function run($action,$data){
	
		switch ($action) {
	
			case 'get':return $this->get($data);break;

			case 'list':return $this->listAdmin($data);break;
	
		}
	}
	
	private function get($data){
		
	}
}