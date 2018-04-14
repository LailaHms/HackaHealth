<?php
echo count($_GET);
echo $_GET['speed'];
echo $_GET['strength'];
echo $_GET['minPosition'];
echo $_GET['maxPosition'];
echo $_GET['referencePosition'];
$settingsDirectory = "settings";
if (!is_dir($settingsDirectory)) {
    mkdir($settingsDirectory);         
}
foreach ($_GET as $key => $value){
	$lockingFile = $settingsDirectory."/".$key.".lock";
	if (!file_exists($lockingFile)){
		fclose(fopen($lockingFile, "w"));
		$myfile = fopen($settingsDirectory."/".$key.".txt", "w")  or die("Unable to open file!");
		fwrite($myfile, $value);
		fclose($myfile);
		unlink($settingsDirectory."/".$key.".lock");
	}
}

?>