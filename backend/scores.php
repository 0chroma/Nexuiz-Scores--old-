<?php
/*************************************\
|        Scores.log optimizer         |
|   Removes any empty match values    |
|       By:  Psychiccyberfreak        |
|          Under the GNU/GPL          |
\*************************************/

header("Content-Type: text/plain");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

require("config.php");

$scoredata = @file_get_contents($pathtoscoreslog) OR die("data file not found or not readable");
$mapscores = explode(":end", $scoredata);

foreach($mapscores AS $v) {
$foo = explode("\n", $v);
if($foo[2]) { echo $v.":end"; }
}
?>