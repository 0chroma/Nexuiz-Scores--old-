<?php
	if(!isset($Base))
	{
		class Base
		{
			var $id;
			function get($id)
			{
				require("./../config.php");
				$tablename = $this->_get_tablename();
				$link = mysql_connect($db_host, $db_username, $db_password)
				   or die('Could not connect: ' . mysql_error());
				mysql_select_db($db_name) or die('Could not select database');
				$query = "SELECT * FROM ${tablename} WHERE ID='${id}' LIMIT 1";
				$result = mysql_query($query) or die('Query failed: ' . mysql_error());
				$line = mysql_fetch_array($result, MYSQL_ASSOC);
				if($line)
				{
					$p = $this->_makeModel($line);
					mysql_free_result($result);
					mysql_close($link);
					return $p;
				}
				else
				{
					mysql_free_result($result);
					mysql_close($link);
					return false;
				}
			}
			function filter($feild, $value)
			{
				require("./../config.php");
				$tablename = $this->_get_tablename();
				$link = mysql_connect($db_host, $db_username, $db_password)
				   or die('Could not connect: ' . mysql_error());
				mysql_select_db($db_name) or die('Could not select database');
				$feild = mysql_real_escape_string($feild);
				//TODO: format value's datatype accordingly
				$value = mysql_real_escape_string($value);
				if(is_array($feild) && is_array($value))
				{
					$query = "SELECT * FROM ${tablename} WHERE ";
					for($i=0; $i < count($field); $i++)
					{
						$query .= $field[$i] . "=\"" . $value[$i] . "\"";
						if($i != count($field)) { $i .= ", "; }
					}
				}
				else { $query = "SELECT * FROM ${tablename} WHERE ${feild}=\"${value}\""; }
				$result = mysql_query($query) or die('Query failed: ' . mysql_error());
				$list = Array();
				while($line = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					array_push($list, $this->_makeModel($line));
					$results = TRUE;
				}
				mysql_free_result($result);
				mysql_close($link);
				if(!isset($results)) { return false; }
				else { return $list; }
			}
			function save()
			{
				require("./../config.php");
				$link = mysql_connect($db_host, $db_username, $db_password)
				   or die('Could not connect: ' . mysql_error());
				mysql_select_db($db_name) or die('Could not select database');
				if(isset($this->id))
				{
					mysql_query($this->_make_mysql_query($this->_get_tablename(), "update")) or die('Query failed: ' . mysql_error());
				}
				else
				{
					mysql_query($this->_make_mysql_query($this->_get_tablename(), "insert")) or die('Query failed: ' . mysql_error());
				}
				if(!isset($this->id)) { $this->id = mysql_insert_id(); }
				mysql_close($link);
			}		
			function _get_tablename()
			{
				require("./../config.php");
				if(isset($this->_tablename))
				{
					$tablename=$this->_tablename;
				}
				else
				{
					$tablename=strtolower(get_class($this));
				}
				return $db_prefix . $tablename;
			}
			function _makeModel($line)
			{
				$p = new $this;
				foreach ($line as $key => $value)
				{
					$p->$key = $value;
				}
				if(isset($line['ID']))
				{
					$p->id = $line['ID'];
					unset($p->ID);
				}
				return $p;
			}
			function _make_mysql_query($table, $type)
			{
				$i = 0;
				//for some reason count($this) returns 0 so...
				$length = $this->count()-1;
				if($type == "update") { $sql = "UPDATE ${table} SET "; }
				else { $sql = "INSERT INTO ${table} SET "; }
				foreach($this as $key => $value)
				{
					if($key != "_tablename")
					{
						if($key == "id")
						{
							$key = "ID";
						}
						if(is_int($value))
						{
							$sql .= mysql_real_escape_string($key) . "=" . $value;
						}
						else
						{
							//when all else fails, make it a string
							$sql .= mysql_real_escape_string($key) . "=\"" . mysql_real_escape_string($value) ."\"";
						}
						if($i != $length)
						{
							$sql .= ", ";
						}
						else
						{
							$sql .= " ";
						}
					}
					$i++;
				}
				$id=$this->id;
				if($type == "update") { $sql .= " WHERE ID=${id} LIMIT 1"; }
				return $sql;
			}
			function count()
			{
				//for some reason count($this) returns 0 so...
				$length = 0;
				foreach($this as $key => $value)
				{
					if($key != "_tablename")
					{
						$length++;
					}
				}
				return $length;
			}
		}
		$Base = new Base();
	}
?>