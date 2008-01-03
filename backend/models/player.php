<?php

class Player extends Base {
	var $name = array('dbtype' => "mediumtext");
	var $user = array('dbtype' => "int", "null" => "true", "type" => "foreignkey", "model" => "User");
}

?>