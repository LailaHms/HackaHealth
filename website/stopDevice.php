<?php
	$command 	= escapeshellcmd("gnome-terminal tab -e 'python2.7 ../python/connection.py disconnect'");
	$output 	= shell_exec($command);
?>