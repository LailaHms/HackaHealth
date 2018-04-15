<?php
echo("gnome-terminal tab -e 'python2.7 ../python/connection.py connect'");
$output 	= exec("sudo -u www-data python2.7 ../python/tools/connection.py connect",$out,$status);
print_r($out);
echo("Success");
?>
