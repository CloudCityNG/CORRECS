<?php
class University{
	public static $currentSession = 2012;
	
	static function newSession(){
		self::$currentSession = self::$currentSession + 1;
	}
}
?>