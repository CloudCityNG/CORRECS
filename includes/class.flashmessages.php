<?php
class FlashMessages {
	protected static $instance = null;
	public function __construct(){
		
	}
	public function getInstance(){
		return new FlashMessages();
		
	}
	
	public function setMessages($message, $type , $key){
		if(strtolower($type) == "error"){
		if(is_array($message)){
				$_SESSION["error"][$key]= "<ul>";
				$_SESSION["error"][$key] .= "<font color = \"red\">";
			foreach($message as $msg){
				
				
				$_SESSION["error"][$key] .="<li>". $msg."</li>";
				
				
			}
			$_SESSION["error"][$key] .="</font></ul>";
			
		}
		else{
		$_SESSION["error"][$key] =  "<ul><li><font color = \"red\">";
			$_SESSION["error"][$key]  .= $message;
			$_SESSION["error"][$key] .= "</font></li></ul>";
		}
		
	}
	elseif(strtolower($type) == "notify"){
		$_SESSION["error"][$key] = "<ul><li><font color = \"green\">";
		$_SESSION["error"][$key] .= $message;
		$_SESSION["error"][$key] .="</font></li></ul>";
				
		
	}
	elseif(strtolower($type) == "information"){
		
		
	} 
	
		
	}
	
	public function displayMessage($key){
		
		if(isset($_SESSION["error"][$key])){
			
			echo $_SESSION["error"][$key];
		}
		
	}
	
	public function unsetMessage($key){
		if(isset($_SESSION["error"][$key]))
		unset($_SESSION["error"][$key]);
	
	}
	
	
	


}