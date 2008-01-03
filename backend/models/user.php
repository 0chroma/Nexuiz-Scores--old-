<?php 
	class User extends Base
	{
		var $username = array('type' => 'mediumtext');
		var $password = array('type' => 'mediumtext');
		var $email = array('type' => 'mediumtext');
		var $level = array('type' => 'mediumtext');
		
		function get_current()
		{
			if(isset($_SESSION['userid']))
			{
				return $this->get($_SESSION['userid']);
			}
			else
			{
				return FALSE;
			}
		}
		function authenticate($user, $pass)
		{
			$line = $this->filter("username", $user);
			if($line != FALSE)
			{
				$pass = crypt($pass, $GLOBALS['conf']['salt']);
				if($line[0]->password == $pass)
				{
					return $line[0];
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
		function login()
		{
			$_SESSION['userid'] = $this->id;
			$_SESSION['username'] = $this->username;
			$_SESSION['userlevel'] = $this->level;
			$_SESSION['userloggedin'] = TRUE;
		}
		function logout()
		{
			$_SESSION['userid'] = null;
			$_SESSION['username'] = null;
			$_SESSION['userlevel'] = null;
			$_SESSION['userloggedin'] = FALSE;
			$this->save();
		}
		function set_password($pass)
		{
			$this->password = crypt($pass, $GLOBALS['conf']['salt']);
		}
		function crypt_password()
		{
			$this->password = crypt($this->password, $GLOBALS['conf']['salt']);
		}
		function generate_password()
		{
			$characters = 10;
			$possible = '23456789bcdfghjkmnpqrstvwxyz'; 
			$code = '';
			$i = 0;
			while ($i < $characters) { 
				$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$i++;
			}
			$this->set_password($code);
			return $code;
		}
	}
	$User = new User();
?>
