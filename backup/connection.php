<?php
  $host="db05.serverhosting.vn";
  $uname="vie7d759_vt";
  $pass="viettrade123456";
  $database = "vie7d759_viettrade";
$connection=mysql_connect($host,$uname,$pass)
or die("Database Connection Failed");
$selectdb=mysql_select_db($database) or die("Database could not be selected");
$result=mysql_select_db($database)
or die("database cannot be selected <br>");
mysql_query("SET NAMES utf8", $connection);
?>