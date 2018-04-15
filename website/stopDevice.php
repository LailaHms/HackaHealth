<?php
echo("gnome-terminal tab -e 'python2.7 ../python/connection.py disconnect'");
$output 	= exec("sudo -u www-data python2.7 ../python/tools/connection.py disconnect",$out,$status);
print_r($out);
echo("Success");
?>
