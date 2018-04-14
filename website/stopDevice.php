<?php
	$command 	= escapeshellcmd("gnome-terminal tab -e 'python3 connection.py'");
	$output 	= shell_exec($command);
?>