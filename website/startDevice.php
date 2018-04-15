<?php
	//$command 	= escapeshellcmd("gnome-terminal tab -e 'python2.7 ../python/connection.py connect'");
	$command 	= escapeshellcmd("python2.7 ../python/connection.py connect");
	$output 	= shell_exec($command);
?>