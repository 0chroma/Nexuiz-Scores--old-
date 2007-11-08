<?php 
	require("base.php");
	class Example extends Base
	{
		var $id;
		var $name;
		var $content;
		var $_tablename = "examples"; //if none provided then it defaults to the class name in lower case
		function doSomething()
		{
			$this->name="something";
			$this->save();
		}
	}
	$App = new App();
	$p = $App->get(4);
	$p->content = "foo!";
	$p->save();
	//I haven't gotten this far yet so make sure you don't do this:
	$p = new App();
	$p->name="Don't do it!!!";
	$p->save();
	$p->content = "No No No!!! AHHH!!!";
	$p->save();
	//that would make two new rows in the DB. If anyone wants to fix that be my guest,
	//but I will get that working one day.
?>